<?php

namespace App\Http\Controllers\Site;

use App\Contracts\ProductContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class ProductController
 * @package App\Http\Controllers\Site
 */
class ProductController extends Controller
{
    /**
     * @var ProductContract
     */
    protected ProductContract $productRepository;

    /**
     * ProductController constructor.
     * @param ProductContract $productRepository
     */
    public function __construct(ProductContract $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function show($slug)
    {
        $product = $this->productRepository->findProductBySlug($slug);

        dd($product);
    }
}
