<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\BrandContract;
use App\Contracts\CategoryContract;
use App\Contracts\ProductContract;
use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreProductFormRequest;

class ProductController extends BaseController
{
    protected $brandRepository;
    protected $categoryRepository;
    protected $productRepository;

    /**
     * ProductController constructor.
     * @param BrandContract $brandRepository
     * @param CategoryContract $categoryRepository
     * @param ProductContract $productRepository
     */
    public function __construct(
        BrandContract $brandRepository,
        CategoryContract $categoryRepository,
        ProductContract $productRepository
    )
    {
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $products = $this->productRepository->listProducts();
        $this->setPageTitle('Products', 'Product List');

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $brands = $this->brandRepository->listBrands('name', 'asc');
        $categories = $this->categoryRepository->listCategories('name', 'asc');
        $this->setPageTitle('Products', 'Create Product');

        return view('admin.products.create', compact('brands', 'categories'));
    }

    public function store(StoreProductFormRequest $request)
    {
        $params = $request->except('_token');

        $product = $this->productRepository->createProduct($params);

        return (!$product)
            ? $this->responseRedirectBack('Error while creating product', 'error', true, true)
            : $this->responseRedirect('admin.products.index', 'Product successfully created.', 'success');
    }

    public function edit($id)
    {
        $product = $this->productRepository->findProductById($id);
        $brands = $this->brandRepository->listBrands('name', 'asc');
        $categories = $this->categoryRepository->listCategories('name', 'asc');
        $this->setPageTitle('Products', 'Create Product');

        return view('admin.products.edit', compact('categories', 'brands', 'product'));
    }

    public function update(StoreProductFormRequest $request)
    {
        $params = $request->except('_token');

        $product = $this->productRepository->updateProduct($params);

        return (!$product)
            ? $this->responseRedirectBack('Error while updating product', 'error', true, true)
            : $this->responseRedirect('admin.products.index', 'Product updated successfully', 'success');
    }

}
