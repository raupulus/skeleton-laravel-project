<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * API Resource para el modelo User.
 * Limita los campos expuestos en las respuestas de la API,
 * evitando revelar información sensible como role, deleted_at, etc.
 */
class UserResource extends JsonResource
{
    /**
     * Transforma el recurso en un array para la respuesta JSON.
     *
     * @param  Request  $request  La petición HTTP actual
     * @return array<string, mixed>  Array con los campos seguros del usuario
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'email'             => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'avatar'            => $this->avatar,
            'created_at'        => $this->created_at,
        ];
    }
}
