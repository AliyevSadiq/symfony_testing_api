<?php

namespace App\Controller;

use App\CQRS\Category\CommandBus\Command\CreateCategoryCommand;
use App\CQRS\Category\CommandBus\Command\DeleteCategoryCommand;
use App\CQRS\Category\CommandBus\Command\UpdateCategoryCommand;
use App\CQRS\Category\QueryBus\Query\FetchCategoriesQuery;
use App\CQRS\Common\Command\CommandBus;
use App\CQRS\Common\Query\QueryBus;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Request\CategoryRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{

    private CategoryRepository $repository;
    private CommandBus $commandBus;
    private QueryBus $queryBus;

    public function __construct(CategoryRepository $repository,CommandBus $commandBus,QueryBus $queryBus)
    {
        $this->repository = $repository;
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $query=new FetchCategoriesQuery();

        return $this->json([
            'data'=>$this->queryBus->handle($query)
        ]);
    }

    #[Route('', name: 'store', methods: ['POST'])]
    public function store(CategoryRequest $request)
    {
        $command=new CreateCategoryCommand($request->title,$request->is_active);
        $this->commandBus->dispatch($command);

        return $this->json([
            'message'=>'created',
            'data'=>$command->category
        ],Response::HTTP_CREATED);
    }

    #[Route('/{category}',name:'edit',methods: ['GET'])]
    public function edit(Category $category)
    {
        return $this->json([
           'data'=>$category
        ]);
    }

    #[Route('/{category}',name:'update',methods: ['PUT'])]
    public function update(Category $category,CategoryRequest $request)
    {
      $command=new UpdateCategoryCommand($category,$request->title,$request->is_active);
      $this->commandBus->dispatch($command);

      return $this->json([
          'data'=>$category
      ]);
    }

    #[Route('/{category}',name:'delete',methods: ['DELETE'])]
    public function delete(Category $category)
    {
       $command=new DeleteCategoryCommand($category);
       $this->commandBus->dispatch($command);

        return $this->json([
            'message'=>'category deleted'
        ],Response::HTTP_NO_CONTENT);
    }
}
