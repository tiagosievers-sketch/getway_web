<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

use OpenApi\Attributes as OA;
#[OA\Schema(title: 'StateMedicaidCollection', properties: [
    new OA\Property(property: 'data', title: 'data', type: 'array', items: new OA\Items(properties: [],
        allOf: [new OA\Schema(ref: '#/components/schemas/StateMedicaid')])),
])]
class StateMedicaidCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
