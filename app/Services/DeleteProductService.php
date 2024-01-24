<?php
namespace App\Services;

use App\Repositories\ProductRepository;

class DeleteProductService
{
    private ProductRepository $repository;
    public function __construct()
    {
        $this->repository = new ProductRepository();
    }

    public function execute(array $ids):void
    {
        foreach($ids as $id){
            $article = $this->repository->getById($id);
            $this->repository->delete($article);
        }
    }
    public function deleteAll()
    {
        $this->repository->deleteAll();
    }
}
