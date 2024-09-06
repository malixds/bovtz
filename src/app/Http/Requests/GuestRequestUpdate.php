<?php

namespace App\Http\Requests;

use App\Repositories\GuestRepository;
use Illuminate\Foundation\Http\FormRequest;

class GuestRequestUpdate extends FormRequest
{
    protected GuestRepository $repository;

    public function __construct(GuestRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $guest = $this->repository->find($this->route('id'));
        return $guest !== null; // Возвращаем true, если гость найден, иначе false
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \src\bovno_app\vendor\laravel\framework\src\Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $guestId = $this->route('id');
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:guests,email,' . $guestId,
            'phone' => 'required|string|max:20|unique:guests,phone,' . $guestId,
            'country' => 'nullable|string|max:255',
        ];
    }
}
