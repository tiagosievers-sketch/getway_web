<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use OpenApi\Attributes as OA;

#[OA\Schema(title: 'StateResource', properties: [
    new OA\Property(property: 'data', title: 'data', properties: [], type: 'object',
        allOf: [new OA\Schema(ref: '#/components/schemas/State')]),
])]
class StateResource extends JsonResource
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
