<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],

            'ingredients' => ['array'],
            'ingredients.*.id' => ['nullable', 'integer', 'exists:ingredients,id'],
            'ingredients.*.name' => ['required', 'string'],
            'ingredients.*.amount' => ['required', 'string'],

            'instructions' => ['array'],
            'instructions.*.id' => ['nullable', 'integer', 'exists:instructions,id'],
            'instructions.*.instruction' => ['required', 'string'],
            'instructions.*.step' => ['required', 'integer', 'min:1'],
        ];
    }
}
