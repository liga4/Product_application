<?php

namespace App\Services;

use App\Models\Book;
use App\Models\DvdDisc;
use App\Models\Furniture;
use App\Repositories\ProductRepository;

class StoreProductService
{
    private ProductRepository $repository;

    public function __construct()
    {
        $this->repository = new ProductRepository();
    }

    public function execute(
        string $sku,
        string $name,
        int $price,
        string $type,
        int $size,
        int $weight,
        int $height,
        int $width,
        int $length
    )
    {
        $class = $type;
        $DvdDisc = DvdDisc::class;
        $Furniture = Furniture::class;
        $Book = Book::class;

        $product =  new $$class(
            $sku,
            $name,
            $price,
            $type,
            $size,
            $weight,
            $height,
            $width,
            $length
        );
        $this->repository->save($product);
    }
    public function exists(string $sku)
    {
        return $this->repository->skuExists($sku);
    }
}