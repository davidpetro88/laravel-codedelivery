<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 5/5/16
 * Time: 10:44 PM
 */

namespace CodeDelivery\Transformers;

use CodeDelivery\Models\User;
use League\Fractal\TransformerAbstract;
use CodeDelivery\Models\Product;

class DeliverymanTransformer extends TransformerAbstract
{
    /**
     * Transform the \User entity
     * @param \User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id'         => (int) $model->id,
            'name'       => $model->name,
            'email'      => $model->email,
            /* place your other model properties here */
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}