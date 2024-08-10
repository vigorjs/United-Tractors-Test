<?php

namespace App\Http\Requests;

use App\Models\CategoryProduct;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCategoryProductRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:'.CategoryProduct::class,
            'description' => 'string|max:255'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.unique' => 'Category already exists',
            'name.string' => 'Name must be string'
        ];
    }
}
