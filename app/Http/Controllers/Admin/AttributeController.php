<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\AttributeContract;
use App\Http\Controllers\BaseController;
use App\Repositories\AttributeRepository;
use Illuminate\Http\Request;

/**
 * Class AttributeController
 * @package App\Http\Controllers\Admin
 */
class AttributeController extends BaseController
{
    /**
     * @var AttributeRepository
     */
    protected $attributeRepository;

    /**
     * AttributeController constructor.
     * @param $attributeRepository
     */
    public function __construct(AttributeContract $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function index()
    {
        $attributes = $this->attributeRepository->listAttributes();
        $this->setPageTitle('Attributes', 'List of all attributes');

        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        $this->setPageTitle('Attributes', 'Create Attribute');
        return view('admin.attributes.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
            'frontend_type' => 'required'
        ]);

        $params = $request->except('_token');

        $attribute = $this->attributeRepository->createAttribute($params);

        if (!$attribute) {
            return $this->responseRedirectBack('Error occurred while creating attribute.', 'error', true, true);
        }
        return $this->responseRedirect('admin.attributes.index', 'Attribute added successfully.', 'success', false, false);
    }

    public function edit($id)
    {
        $attribute = $this->attributeRepository->findAttributeById($id);
        $this->setPageTitle('Attribute', 'Edit attribute : ' . $attribute->name);

        return view('admin.attributes.edit', compact('attribute'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
            'frontend_type' => 'required'
        ]);

        $params = $request->except('_token');

        $attribute = $this->attributeRepository->updateAttribute($params);

        return (!$attribute)
            ? $this->responseRedirectBack('Error while updating attribute.', 'error', true, true)
            : $this->responseRedirect('admin.attributes.index', 'Attribute successfully updated.', 'success', false, false);
    }

    public function delete($id)
    {
        $attribute = $this->attributeRepository->deleteAttribute($id);

        return (!$attribute)
            ? $this->responseRedirectBack('Error while deleting attribute.', 'error', true, true)
            : $this->responseRedirect('admin.attributes.index', 'Attribute successfully deleted.', 'success', false, false);
    }

}
