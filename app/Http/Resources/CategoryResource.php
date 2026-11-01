<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * API Resource para el modelo Category.
 * Expone únicamente atributos públicos y oculta metadatos internos (deleted_at, pivot).
 */
class CategoryResource extends JsonResource
{
    /**
     * Transforma el recurso en un array para la respuesta JSON.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'description' => $this->whenHas('description'),
            'image' => $this->whenHas('image'),
            'sort_order' => $this->whenHas('sort_order'),
        ];
    }
}
