<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePoolTableRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'price_per_hour' => 'required',
            'status' => 'required|in:1,0',
            'x' => 'required|integer',
            'y' => 'required|integer',
            'orientation' => 'required|in:horizontal,vertical',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama meja wajib diisi.',
            'name.string' => 'Nama meja harus berupa teks.',
            'name.max' => 'Nama meja tidak boleh lebih dari 255 karakter.',

            'price_per_hour.required' => 'Harga per jam wajib diisi.',

            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status hanya boleh bernilai Aktif atau Nonaktif.',

            'orientation.required' => 'Orientasi meja wajib dipilih.',
            'orientation.in' => 'Orientasi hanya boleh horizontal atau vertical.',
        ];
    }
}
