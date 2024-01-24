<?php
declare(strict_types=1);

namespace App\Services;

use App\Collections\ProductCollection;
use App\Repositories\ProductRepository;

class IndexProductService
{
    private ProductRepository $repository;
    public function __construct()
    {
        $this->repository = new ProductRepository();
    }

    public function execute():ProductCollection
    {
        return $this->repository->getAll();
    }
    public function isEmpty()
    {
        return $this->repository->isTableEmpty();
    }
}