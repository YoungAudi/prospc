<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProspectoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nombre' => 'required|max:255',
            'area' => 'nullable|max:255',
            'empresa' => 'nullable|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|max:14',
            'ciudad' => 'required|max:255',
            'estado' => 'required|max:255',
        ];
    }
}
