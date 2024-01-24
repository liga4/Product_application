<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Collections\ProductCollection;
use App\RedirectResponse;
use App\Response;
use App\Services\DeleteProductService;
use App\Services\IndexProductService;
use App\Services\StoreProductService;
use App\ViewResponse;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;

class ProductController
{
    public function index()
    {

        $service = new IndexProductService();
        if($service->isEmpty())
        {
            $products = null;
            return new ViewResponse('products/index', [
                'products' => $products
            ]);
        }
        $products = $service->execute();

        return new ViewResponse('products/index', [
            'products' => $products,
        ]);
    }

    public function create(): Response
    {
        return new ViewResponse('products/create');
    }

    public function store()
    {
        $service = new StoreProductService();

        $validSku = Validator::callback(function ($input) use ($service) {
            return Validator::notEmpty()
                    ->not(Validator::space())
                    ->validate($input) && !$service->exists($input);
        })->setName('Sku')
        ->setTemplate('Sku must be unique.');
        try {
            $validSku->assert($_POST['sku']);
        } catch (NestedValidationException $exception) {
            $this->handleValidationException($exception);
            return new RedirectResponse('/add-product');
        }
        $validName = Validator::notEmpty()
            ->not(Validator::space())
            ->setName('Name');
        try {
            $validName->assert($_POST['name']);
        } catch (NestedValidationException $exception) {
            $this->handleValidationException($exception);
            return new RedirectResponse('/add-product');
        }
        $validPrice = Validator::notEmpty()
            ->not(Validator::space())
            ->setName('Price');
        try {
            $validPrice->assert($_POST['price']);
        } catch (NestedValidationException $exception) {
            $this->handleValidationException($exception);
            return new RedirectResponse('/add-product');
        }
        $validProductType = Validator::not(Validator::equals('----'))
            ->setName('Price')
            ->setTemplate('Please select a valid product type.');
        try {
            $validProductType->assert($_POST['productType']);
        } catch (NestedValidationException $exception) {
            $this->handleValidationException($exception);
            return new RedirectResponse('/add-product');
        }

        $service->execute(
            $_POST['sku'],
            $_POST['name'],
            intval($_POST['price']),
            $_POST['productType'],
            intval($_POST['size']),
            intval($_POST['weight']),
            intval($_POST['height']),
            intval($_POST['width']),
            intval($_POST['length']),
        );
        return new RedirectResponse('/');
    }
    public function delete()
    {
        $id = $_POST['delete-checkbox'];
        $service = new DeleteProductService();
        $service->execute($id);

        return new RedirectResponse('/');
    }
    private function handleValidationException(NestedValidationException $exception): void
    {
        $messages = $exception->getMessages();
        foreach ($messages as $validator => $message) {
            $_SESSION['flush']['error'][] = $message;
        }
    }
    public function deleteAll()
    {
        $service = new DeleteProductService();
        $service->deleteAll();

        return new RedirectResponse('/');
    }
}