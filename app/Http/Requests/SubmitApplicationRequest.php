<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'SubmitApplicationRequest',
    required: ['idProofingIndicator', 'signatureName', 'signatureDate', 'signatureType'],
    properties: [
        new OA\Property(property: "idProofingIndicator", description: "Id proofing flag for the contact household. Contact household needs to be set to true for submissions.", type: "boolean"),
        new OA\Property(property: "signatureName", description: "The signature of the applicant, authorized representative or agent broker who is requesting submission of the application.", type: "string"),
        new OA\Property(property: "signatureDate", description: "The date the application was signed by the applicant, authorized representative or agent broker.", type: "string"),
        new OA\Property(property: "signatureType", description: "Signature type", type: "string", enum: ["APPLICANT", "AUTHORIZED_REPRESENTATIVE", "AGENT_BROKER"]),
        new OA\Property(property: "requestMedicaidDeterminationMembers", description: "List of members requesting Medicaid determination.", type: "array", items: new OA\Items(ref:'#/components/schemas/CostSharing') /**TODO CRIAR O COMPONENTE DE ITENS AQUI**/)
    ]
)]
class SubmitApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'idProofingIndicator' => 'required|boolean',
            'signatureName' => 'required|string',
            'signatureDate' => 'required|date',
            'signatureType' => 'required|string|in:APPLICANT,AUTHORIZED_REPRESENTATIVE,AGENT_BROKER',
            'requestMedicaidDeterminationMembers' => 'nullable|array'
        ];
    }
}
