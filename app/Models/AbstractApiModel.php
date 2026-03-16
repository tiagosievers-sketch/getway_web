<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LdapRecord\Support\Arr;

use OpenApi\Attributes as OA;

#[OA\Schema(title: 'AbstractApiModel', properties: [
])]
abstract class AbstractApiModel extends Model
{

}
