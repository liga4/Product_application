<?php
declare(strict_types=1);

namespace App\Models;
abstract class Product
{
    protected int $id;
    protected string $sku;
    protected string $name;
    protected int $price;
    protected string $productType;
    protected ?int $size;
    protected ?int $weight;
    protected ?int $height;
    protected ?int $width;
    protected ?int $length;

    abstract public function __construct(
        string $sku,
        string $name,
        int    $price,
        string $productType,
        ?int   $size,
        ?int   $weight,
        ?int   $height,
        ?int   $width,
        ?int   $length
    );

    abstract public function setId(int $id): void;

    abstract public function getId(): int;

    abstract public function getSku(): string;

    abstract public function getName(): string;

    abstract public function getPrice(): int;

    abstract public function getProductType(): string;

    abstract public function getSize(): ?int;

    abstract public function getWeight(): ?int;

    abstract public function getHeight(): ?int;

    abstract public function getWidth(): ?int;

    abstract public function getLength(): ?int;
}