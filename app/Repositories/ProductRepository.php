<?php
namespace App\Repositories;
use App\Collections\ProductCollection;
use App\Models\Furniture;
use App\Models\Product;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Dotenv;
use App\Models\DvdDisc;
use App\Models\Book;

class ProductRepository
{
    protected Connection $database;

    public function __construct()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        $connectionParams = [
            'dbname' => 'products',
            'user' => 'root',
            'password' => $_ENV['mysql_password'],
            'host' => 'localhost',
            'driver' => 'pdo_mysql'
        ];
        $this->database = DriverManager::getConnection($connectionParams);
    }
    public function getAll()
    {
        $products = $this->database->createQueryBuilder()
            ->select('*')
            ->from('products')
            ->fetchAllAssociative();

        $productCollection = new ProductCollection();

        foreach ($products as $data) {
            $productCollection->add(
                $this->buildModel($data)
            );
        }
        return $productCollection;
    }
    function isTableEmpty(): bool
    {
        $queryBuilder = $this->database->createQueryBuilder();
        $result = $queryBuilder
            ->select('COUNT(*) as count')
            ->from('products')
            ->execute()
            ->fetchAssociative();

        return intval($result['count']) === 0;
    }
    public function skuExists(string $sku): bool
    {
        $result = $this->database->createQueryBuilder()
            ->select('COUNT(*)')
            ->from('products')
            ->where('sku = :sku')
            ->setParameter('sku', $sku)
            ->executeQuery()
            ->fetchOne();

        return $result > 0;
    }
    private function buildModel(array $data):Product
    {
        $class = $data['product_type'];
        $DvdDisc = DvdDisc::class;
        $Furniture = Furniture::class;
        $Book = Book::class;

        $product = new $$class(
            $data['sku'],
            $data['name'],
            $data['price'],
            $class,
            $data['size'],
            $data['weight'],
            $data['height'],
            $data['width'],
            $data['length']
        );
        $product->setId($data['id']);
        return $product;
    }
    public function save(Product $product): void
    {
        $this->insert($product);
    }
    private function insert(Product $product):void
    {
        $this->database->createQueryBuilder()
            ->insert('products')
            ->values(
                [
                    'name' => ':name',
                    'sku' => ':sku',
                    'price' => ':price',
                    'product_type' => ':product_type',
                    'size' => ':size',
                    'weight' => ':weight',
                    'height' => ':height',
                    'width' => ':width',
                    'length' => ':length',
                ]
            )->setParameters([
                'name' => $product->getName(),
                'sku' => $product->getSku(),
                'price' => $product->getPrice(),
                'product_type' => $product->getProductType(),
                'size' => $product->getSize(),
                'weight' => $product->getWeight(),
                'height' => $product->getHeight(),
                'width' => $product->getWidth(),
                'length' => $product->getLength(),
            ])->executeQuery();
    }
    public function getById(string $id): ?Product
    {
        $data = $this->database->createQueryBuilder()
            ->select('*')
            ->from('products')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->fetchAssociative();
        if (empty($data)) {
            return null;
        }
        return $this->buildModel($data);
    }
    public function delete(Product $product): void
    {
        $this->database->createQueryBuilder()
            ->delete('products')
            ->where('id = :id')
            ->setParameter('id', $product->getId())
            ->executeQuery();
    }
    public function deleteAll(): void
    {
        $this->database->delete('products', ['1' => '1']);
    }
}