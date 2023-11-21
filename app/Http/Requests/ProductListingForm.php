<?php

namespace App\Http\Requests;

use App\Models\Attribute;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ProductListingForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $attributes = Attribute::select('key')->whereNotIn('key', ['Price', 'Color'])->get()->unique('key')->pluck('key')->values()->toArray();
        $inputs = $this->all();
        $inputs_attribute = array_filter($inputs, function ($var) use ($attributes) {
            return in_array($var, $attributes, true);
        }, ARRAY_FILTER_USE_KEY);
        $attribute_list = [];
        foreach ($inputs_attribute as $key => $value) {
            $attribute_list[$key] = $value;
        }
        $this->merge([
            'attributes' => $attribute_list,
        ]);
        foreach ($inputs_attribute as $attribute) {
            $this->request->remove($attribute);
        }
    }

    // protected function failedValidation(Validator $validator)
    // {
    //        dd($validator->errors());
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'imageToUpload' => 'required',
            'title' => 'required|max:100',
            'description' => 'nullable|max:5000',
            'category' => 'required|exists:categories,id',
            'size' => 'required|exists:attributes,value',
            'color' => 'required|exists:attributes,value',
            'price' => 'required|gt:0',
        ];
    }
}
