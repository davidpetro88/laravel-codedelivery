<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 5/6/16
 * Time: 7:50 PM
 */

namespace CodeDelivery\Http\Requests;


class AdminOrderRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }

}