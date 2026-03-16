<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LdapRecord\Support\Arr;

use OpenApi\Attributes as OA;

#[OA\Schema(title: 'AbstractModel', properties: [
    new OA\Property(property: 'id', title: 'id', description: 'PK', type: 'integer', writeOnly: true,
        nullable: true),
    new OA\Property(property: 'created_at', title: 'created_at', description: 'Register creation date', type: 'string', writeOnly: true,
        nullable: true),
    new OA\Property(property: 'updated_at', title: 'updated_at', description: 'Register update date', type: 'string', writeOnly: true,
        nullable: true),
])]
abstract class AbstractModel extends Model
{

}
