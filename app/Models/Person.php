<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;
use PhpParser\Node\Expr\AssignOp\Mod;

#[OA\Schema(title: 'Person', allOf: [
    new OA\Schema(properties: [
        new OA\Property(property: "age", description: 'required if not send dob', type: "number", format: "integer", nullable: true),
        new OA\Property(property: "dob", description: "A person's date of birth (YYYY-MM-DD) required if age not provided", type: "string", pattern: ' ^[0-9]{4}-[0-9]{2}-[0-9]{2}$', nullable: true),
        new OA\Property(property:"has_mec", type:"boolean", nullable: true),
        new OA\Property(property:"is_pregnant", type:"boolean", nullable: true),
        new OA\Property(property:"pregnant_with", type:"number", format:"integer", nullable: true),
        new OA\Property(property:"uses_tobacco", type:"boolean", nullable: true),
        new OA\Property(property: "last_tobacco_use_date", description: "A person's date of birth (YYYY-MM-DD) required if age not provided", type: "string", pattern: ' ^[0-9]{4}-[0-9]{2}-[0-9]{2}$', nullable: true),
        new OA\Property(property:"gender", type:"string", enum: ['Male', 'Female'], nullable: true),
        new OA\Property(property:"utilization_level", type:"string", enum: [ 'Low', 'Medium', 'High'], nullable: true),
        new OA\Property(property:"relationship", type:"string", nullable: true),
        new OA\Property(property:"does_not_cohabitate", type:"boolean", nullable: true),
        new OA\Property(property: "current_enrollment", ref: '#/components/schemas/CurrentEnrollment', description: 'Current/existing enrollment information used to determine tobacco status for CiC enrollments. This will ensure rate calculation is done correctly.', type: "object", nullable: true),
    ], type: 'object'),
    new OA\Schema(ref: '#/components/schemas/AbstractApiModel'),
])]
class Person extends Model
{
    use HasFactory;
}
