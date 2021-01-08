<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\BrandContract;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class BrandController
 * @package App\Http\Controllers\Admin
 */
class BrandController extends BaseController
{

    /**
     * @var
     */
    protected $brandRepository;

    /**
     * BrandController constructor.
     * @param BrandContract $brandRepository
     */
    public function __construct(BrandContract $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function index()
    {
        $brands = $this->brandRepository->listBrands();

        $this->setPageTitle('Brands', 'List of all brands');
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        $this->setPageTitle('Brands', 'Create brand');
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:191',
            'logo' => 'mimes:jpg,jpeg,png|max:1000'
        ]);

        $params = $request->except('_token');

        $brand = $this->brandRepository->createBrand($params);

        return (!$brand)
            ? $this->responseRedirectBack('Error while creating brand', 'error', true, true)
            : $this->responseRedirect('admin.brands.index', 'Brand created successfully');
    }

    public function edit($id)
    {
        $brand = $this->brandRepository->findBrandById($id);

        $this->setPageTitle('Brands', 'Edit brand: ' . $brand->name);
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:191',
            'logo' => 'mimes:jpg,jpeg,png|max:1000'
        ]);

        $params = $request->except('_token');

        $brand = $this->brandRepository->updateBrand($params);

        return (!$brand)
            ? $this->responseRedirectBack('Error while updating brand.', 'error', true, true)
            : $this->responseRedirect('admin.brands.index', 'Brand updated successfully.', 'success');
    }

    public function delete($id)
    {
        $brand = $this->brandRepository->deleteBrand($id);

        return (!$brand)
            ? $this->responseRedirectBack('Error while deleting brand.', 'error', true, true)
            : $this->responseRedirect('admin.brands.index', 'Brand deleted successfully.', 'success');

    }
}
