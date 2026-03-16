<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use OpenApi\Attributes as OA;

#[OA\Schema(title: 'StateMedicaidResource', properties: [
    new OA\Property(property: 'data', title: 'data', properties: [], type: 'object',
        allOf: [new OA\Schema(ref: '#/components/schemas/StateMedicaid')]),
])]
class StateMedicaidResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
