<?php

namespace App\Models;

class Furniture extends Product
{
    public function __construct(
        string $sku,
        string $name,
        int    $price,
        string $productType,
        ?int   $size,
        ?int   $weight,
        ?int   $height,
        ?int   $width,
        ?int   $length
    )
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->productType = $productType;
        $this->size = $size;
        $this->weight = $weight;
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getProductType(): string
    {
        return $this->productType;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }
}