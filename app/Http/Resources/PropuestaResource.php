<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropuestaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'observaciones' => $this->observaciones,
            'tipo_show' => $this->tipo_show,
            'duracion' => $this->duracion,
            'costo' => $this->costo,
            'viaticos' => round($this->viaticos,0),
            'fecha_valido' => $this->fecha_valido,
            'fecha_cotizacion' => $this->fecha_cotizacion,
            'evento_id' => $this->evento_id,
            'talento_id' => $this->talento_id,
            'needs' => new NeedCollection($this->needs),
        ];
    }
}
