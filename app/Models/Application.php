<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Application', allOf: [
    new OA\Schema(properties: [
    ], type: 'object')
])]
class Application extends Model
{
    use HasFactory;

    protected $fillable = [
    ];
}
