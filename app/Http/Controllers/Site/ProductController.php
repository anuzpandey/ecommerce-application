<?php

namespace App\Http\Controllers\Site;

use App\Contracts\AttributeContract;
use App\Contracts\ProductContract;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
     * @var AttributeContract
     */
    protected AttributeContract $attributeRepository;

    /**
     * ProductController constructor.
     * @param ProductContract $productRepository
     * @param AttributeContract $attributeRepository
     */
    public function __construct(ProductContract $productRepository, AttributeContract $attributeRepository)
    {
        $this->productRepository = $productRepository;
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * @param $slug
     * @return Application|Factory|View
     */
    public function show($slug)
    {
        $product = $this->productRepository->findProductBySlug($slug);
        $attributes = $this->attributeRepository->listAttributes();

        return view('site.pages.product', compact('product', 'attributes'));
    }

    /**
     * @param Request $request
     */
    public function addToCart(Request $request)
    {
        dd($request->all());
    }
}
