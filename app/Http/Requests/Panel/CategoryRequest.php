<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:3',
                'max:255',
                Rule::unique('categories', 'name')->ignore($this->category_id)
            ],
            'category_id' => 'nullable|number',
            'image' => 'nullable|image',
            'description' => 'required|string|min:5|max:500',
            'icon' => 'nullable|string',
            'color' => 'nullable|string',
            'slug' => [
                'required',
                'min:5',
                'max:511',
                Rule::unique('categories', 'slug')->ignore($this->category_id)
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->slug),
        ]);
    }
}
