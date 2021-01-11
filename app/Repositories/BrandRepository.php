<?php


namespace App\Repositories;

use App\Contracts\BrandContract;
use App\Models\Brand;
use App\Traits\UploadAble;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;

/**
 * Class BrandRepository
 * @package App\Repositories
 */
class BrandRepository extends BaseRepository implements BrandContract
{
    use UploadAble;


    /**
     * BrandRepository constructor.
     */
    public function __construct(Brand $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function listBrands(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    public function createBrand(array $params)
    {
        try {

            $collection = collect($params);

            $logo = null;

            if ($collection->has('logo') && ($params['logo'] instanceof UploadedFile)) {
                $logo = $this->uploadOne($params['logo'], 'brands');
            }

            $merge = $collection->merge(compact('logo'));

            return Brand::create($merge->all());

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    public function updateBrand(array $params)
    {
        $brand = $this->findBrandById($params['id']);

        $collection = collect($params)->except('_token');

        $logo = null;

        if ($collection->has('logo') && ($params['logo'] instanceof UploadedFile)) {
            if ($brand->logo != null) {
                $this->deleteOne($brand->logo);
            }
            $logo = $this->uploadOne($params['logo'], 'brands');
        } else {
            $logo = $brand->logo;
        }

        $merge = $collection->merge(compact('logo', ''));

        $brand->update($merge->all());

        return $brand;
    }

    public function findBrandById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception);
        }
    }

    public function deleteBrand($id)
    {
        $brand = $this->findBrandById($id);

        if ($brand->logo != null) {
            $this->deleteOne($brand->logo);
        }

        $brand->delete();

        return $brand;
    }
}
