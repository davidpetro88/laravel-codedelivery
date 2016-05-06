<?php

namespace CodeDelivery\Transformers;

use CodeDelivery\Models\Product;
use League\Fractal\TransformerAbstract;

/**
 * Class ProductTransformer
 * @package namespace CodeDelivery\Transformers;
 */
class ProductTransformer extends TransformerAbstract
{

    /**
     * Transform the \Product entity
     * @param \Product $model
     *
     * @return array
     */
    public function transform(Product $model)
    {
        return [
            'id'         => (int) $model->id,
            'name'       =>   $model->name,
            'description'       =>   $model->description,
            'price'       =>   (float)$model->price,
            /* place your other model properties here */
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
