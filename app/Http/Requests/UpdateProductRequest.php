<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'string',
            'price' => 'integer|min:0',
            'image' => 'mimes:png,jpg,jpeg|max:2048',
            "product_category_id" => "integer"
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'Name must be string',
            'price.integer' => 'Price must be integer',
            'price.min' => 'Price min 0',
            'image.max' => 'Image max 2mb',
            'product_category_id.integer' => 'must be integer'
        ];
    }
}
