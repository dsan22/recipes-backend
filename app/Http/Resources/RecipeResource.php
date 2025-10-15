<?php

namespace App\Http\Resources;

use App\Models\Instruction;
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
            'description' => $this->description,
            'ingredients'=> IngredientResource::collection($this->ingredients),
            'user'=>$this->user->name,
            'cover_image'=>$this->get_cover_image(),
            'images'=>$this->images()->get()->pluck('image')->map(function ($image) {
                return asset( "storage/".$image);
            }),
            'instructions'=> InstructionResource::collection($this->instructions()->orderBy('step')->get()),
            'category' => $this->category->name,
            'created_at' => $this->created_at,
            'updated_at'=> $this->updated_at ,
        ];
    }
}
