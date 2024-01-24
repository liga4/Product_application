<?php
declare(strict_types=1);

namespace App\Collections;

use App\Models\Product;

class ProductCollection
{
    private array $products;

    public function __construct(array $products = [])
    {

        foreach ($products as $product)
        {
            if (!$product instanceof Product)
            {
                continue;
            }
            $this->add($product);
        }
    }
    public function add(Product $product): void
    {
        $this->products[]= $product;
    }
    public function getAll(): array
    {
        return $this->products;
    }
}