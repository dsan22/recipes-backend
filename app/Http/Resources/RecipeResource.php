<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'instructions' => $this->instructions,
            'ingredients'=> IngredientResource::collection($this->ingredients),
            'user'=>$this->user->name,
            'category' => $this->category->name,
            'created_at' => $this->created_at,
            'updated_at'=> $this->updated_at ,
        ];
    }
}
