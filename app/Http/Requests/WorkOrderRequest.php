<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

          return [
               'order_status' => 'required',
               'name' => 'required',
               'unit_number' => 'required',
               'category' => 'required',
               'description' => 'required',
               'comments' => 'required',
               'permission_to_enter' => 'required',
               // 'created_at' => 'required'
           ];


    }
}
