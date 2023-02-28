<?php

namespace App\Controller\Admin;

use App\CQRS\CommandBus\CommandBus;
use App\CQRS\CommandBus\Commands\Product\DeleteProductCommand;
use App\CQRS\CommandBus\Commands\Product\SaveProductCommand;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Requests\ProductCreateRequest;
use App\Utils\Collection\ProductCollection;
use App\Utils\Collection\Resource\ProductResourceCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Admin Product Crud')]
#[Route('/admin/product', name: 'admin_product_')]
class ProductController extends AbstractController
{

    public function __construct(private CommandBus $commandBus)
    {
    }


    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ProductRepository $repository): JsonResponse
    {
        try {
            $this->denyAccessUnlessGranted('product_list', Product::class);
            return $this->json([
                'products' => ProductCollection::collection($repository->findAll())
            ]);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), $e->getCode());
        }

    }

    #[Route('/{slug}', name: 'edit', methods: ['GET'], priority: 1)]
    public function edit(Product $product)
    {
        try {
            $this->denyAccessUnlessGranted('product_edit', Product::class);
            return $this->json([
                'product' => (new ProductResourceCollection($product))->get()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), $e->getCode());
        }

    }

    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(properties: [
            new OA\Property(type: 'string', example: 'product_title', property: 'title'),
            new OA\Property(type: 'string', example: 'product_description', property: 'description'),
            new OA\Property(type: 'integer', example: 1, property: 'category_id'),
            new OA\Property(type: 'decimal', example: 10, property: 'price'),
            new OA\Property(type: 'boolean', example: false, property: 'is_show'),
        ])
    )]
    #[Route('/store', name: 'store', methods: ['POST'], priority: 2)]
    #[Route('/{id}/update', name: 'update', methods: ['POST'])]
    public function store(ProductCreateRequest $request, Product $product = null)
    {
        try {
            $this->denyAccessUnlessGranted('product_save', Product::class);
            $extra_field = [];

            if ($product) {
                $extra_field['product'] = $product;
            }
            $command = new SaveProductCommand($request->getRequest($extra_field));
            $this->commandBus->dispatch($command);

            return $this->json([
                'product' => (new ProductResourceCollection($command->product))->get()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), $e->getCode());
        }
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['DELETE'])]
    public function delete(Product $product)
    {
        try {
            $this->denyAccessUnlessGranted('product_delete', Product::class);
            $command = new DeleteProductCommand([
                'product' => $product
            ]);
            $this->commandBus->dispatch($command);
            return $this->json([
                'message' => 'Product deleted'
            ]);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), $e->getCode());
        }

    }
}
