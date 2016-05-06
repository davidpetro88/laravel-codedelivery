<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 5/5/16
 * Time: 11:02 PM
 */

namespace CodeDelivery\Models;


use Illuminate\Contracts\Support\Jsonable;


class Geo implements Jsonable{
    public $lat;
    public $long;
    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode([
            'lat' =>$this->lat,
            'long'=> $this->long
        ]);
    }
}