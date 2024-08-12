<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RekeningRequest extends FormRequest
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


    public function messages(): array
    {
        return [
            'required' => ':attribute harus diisi',
            'nama_lengkap.regex' => ':attribute hanya boleh berupa huruf dan spasi',
            'nominal.regex' => ':attribute hanya boleh berupa angka',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_lengkap' => 'Nama Lengkap',
            'tempat_lahir' => 'Tempat Lahir',
            'tgl_lahir' => 'Tanggal Lahir',
            'jk' => 'Jenis Kelamin',
            'pekerjaan' => 'Pekerjaan',
            'nominal' => 'Nominal',
        ];
    }
    public function rules(): array
    {
        return [
            'nama_lengkap' => 'required | regex:/^[a-zA-Z\s]+$/',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required | date',
            'jk' => 'required',
            'pekerjaan' => 'required',
            'nominal' => 'required | regex:/^[0-9]+$/',
        ];
    }
}
