<?php

namespace App\Controller\Admin;

use App\CQRS\CommandBus\CommandBus;
use App\CQRS\CommandBus\Commands\Category\DeleteCategoryCommand;
use App\CQRS\CommandBus\Commands\Category\SaveCategoryCommand;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Requests\CategoryCreateRequest;
use App\Utils\Collection\CategoryCollection;
use App\Utils\Collection\Resource\CategoryResourceCollection;
use Doctrine\DBAL\Driver\Exception;
use Nelmio\ApiDocBundle\Model\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Admin Category Crud')]
#[Route('/admin/category', name: 'admin_category_')]
class CategoryController extends AbstractController
{

    public function __construct(private CommandBus $bus)
    {
    }


    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): JsonResponse
    {
        try {
            $this->denyAccessUnlessGranted('category_list', Category::class);
            return $this->json([
                'categories' => CategoryCollection::collection($categoryRepository->findAll()),
            ]);
        } catch (Exception $e) {
            return new JsonResponse($e->getMessage(), $e->getCode());
        }

    }

    #[OA\RequestBody(
        required: true,
        content: [new OA\MediaType(mediaType: 'multipart/form-data',
            schema: new OA\Schema(properties: [
                new OA\Property(type: 'string', example: 'category_title', property: 'title'),
                new OA\Property(type: 'booelan', example: false, property: 'is_show'),
            ])
        )]
    )]
    #[Route('/store', name: 'store', methods: ['POST'], priority: 2)]
    #[Route('/{id}/update', name: 'update', methods: ['PUT'])]
    public function save(CategoryCreateRequest $request, Category $category = null)
    {
        try {
            $this->denyAccessUnlessGranted('category_save', Category::class);
            $extra_field = [];
            if ($category) {
                $extra_field['category'] = $category;
            }
            $command = new SaveCategoryCommand($request->getRequest($extra_field));
            $this->bus->dispatch($command);
            return $this->json([
                'category' => (new CategoryResourceCollection($command->category))->get()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), $e->getCode());
        }
    }

    #[Route('/{slug}', name: 'edit', methods: ['GET'], priority: 1)]
    public function edit(Category $category): JsonResponse
    {
        try {
            $this->denyAccessUnlessGranted('category_edit', Category::class);

            return $this->json([
                'category' => (new CategoryResourceCollection($category))->get()
            ]);
        } catch (Exception $e) {
            return new JsonResponse($e->getMessage(), $e->getCode());
        }

    }


    #[Route('/{id}/delete', name: 'delete', methods: ['DELETE'])]
    public function delete(Category $category, Request $request)
    {
        try {
            $this->denyAccessUnlessGranted('category_delete', Category::class);
            $command = new DeleteCategoryCommand(
                [
                    'category' => $category
                ]
            );
            $this->bus->dispatch($command);
            return $this->json([
                'Category deleted'
            ]);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), $e->getCode());
        }
    }
}
