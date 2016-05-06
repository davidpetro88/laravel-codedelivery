<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 5/5/16
 * Time: 11:03 PM
 */

namespace CodeDelivery\Models;


use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class OauthClient extends Model implements Transformable
{
    use TransformableTrait;
}