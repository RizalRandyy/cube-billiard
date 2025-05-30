<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => 'required|email|max:50',
            'phone' => 'required|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|string|max:50',
            'confirm_password' => 'required|string|same:password|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa string.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus berupa dalam format email (testo@gmail.com).',
            'email.max' => 'Email tidak boleh lebih dari 50 karakter.',
            
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.string' => 'Nomor telepon harus berupa dalam format email (testo@gmail.com).',
            'phone.max' => 'Nomor telepon tidak boleh lebih dari 50 karakter.',

            'role_id.required' => 'Role wajib diisi.',

            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa string.',
            'password.max' => 'Password tidak boleh lebih dari 50 karakter.',

            'confirm_password.same' => 'Konfirmasi password harus sama dengan password.',
        ];
    }
}
