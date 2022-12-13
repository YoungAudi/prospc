<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropuestaRequest extends FormRequest
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
            'observaciones' => 'nullable|max:255',
            'tipo_show' => 'nullable|max:255',
            'duracion' => 'nullable|max:255',
            'costo' => 'required|max:255',
            'fecha_valido' => 'required|date_format:Y-m-d',
            'fecha_cotizacion' => 'required|date_format:Y-m-d',
            'descripcion' => 'required|max:255',
            // 'archivo' => 'required|mimes:pdf',
            'evento_id' => 'required|exists:eventos,id',
            'talento_id' => 'required|exists:talentos,id',
            'tipo' => 'nullable|array',
            'tipo.*' => 'required|max:255',
            'nombres' => 'nullable|array',
            'tipo.*' => 'required|max:255',
            'ids' => 'nullable|array',
            'ids.*' => 'required|exists:needs,id'
        ];
    }
}
