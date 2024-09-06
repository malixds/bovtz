<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestRequest extends FormRequest
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
     * @return array<string, \src\bovno_app\vendor\laravel\framework\src\Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:guests',
            'phone'      => 'required|string|max:20|unique:guests',
            'country'    => 'nullable|string|max:255',
        ];
    }
}
