<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'UpdateApplicationRequest',
    required: ['application', 'household', 'members', 'removedMembers'],
    properties: [
        new OA\Property(property: "application", type: "object", required: [
            "legalAttestations",
            "insuranceApplicationSecurityQuestionType",
            "insuranceApplicationSecurityQuestionAnswer",
            "applicationSignatures",
            "applicationAssistors",
            "requestingFinancialAssistanceIndicator",
            "contactMemberIdentifier",
            "contactInformation",
            "spokenLanguageType",
            "writtenLanguageType",
            "coverageState",
            "accountHolderIdentityProofedIndicator"
        ], properties: [
            new OA\Property(property: "legalAttestations", type: "object", required: [
                "absentParentAgreementIndicator",
                "changeInformationAgreementIndicator",
                "medicaidRequirementAgreementIndicator",
                "renewEligibilityYearQuantity",
                "nonIncarcerationAgreementIndicator",
                "penaltyOfPerjuryAgreementIndicator",
                "renewalAgreementIndicator",
                "terminateCoverageOtherMecFoundAgreementIndicator"
            ], properties: [
                new OA\Property(property: "absentParentAgreementIndicator", type: "boolean", description: "Indicates that the insurance member attests to cooperating with medical support collection agency."),
                new OA\Property(property: "changeInformationAgreementIndicator", type: "boolean", description: "Indicates that the insurance member understands that changed information needs to be reported."),
                new OA\Property(property: "medicaidRequirementAgreementIndicator", type: "boolean", description: "Indicates that the insurance member understands the Medicaid requirements."),
                new OA\Property(property: "renewEligibilityYearQuantity", type: "number", description: "Number of years that the member gives permission for his/her eligibility for help paying for health insurance to be renewed."),
                new OA\Property(property: "nonIncarcerationAgreementIndicator", type: "boolean", description: "Indicates that the member attests that no one applying for health insurance on the application is incarcerated."),
                new OA\Property(property: "penaltyOfPerjuryAgreementIndicator", type: "boolean", description: "Indicates that the member understands he or she is signing this application under penalty of perjury."),
                new OA\Property(property: "renewalAgreementIndicator", type: "boolean", description: "Indicates that the insurance member understands the renewal process rules."),
                new OA\Property(property: "terminateCoverageOtherMecFoundAgreementIndicator", type: "boolean", description: "Indicates whether the contact understands and agrees that if members of their household are found to be enrolled in other qualifying coverage (including Medicaid, CHIP, and Medicare), the Marketplace may terminate their Marketplace coverage.")
            ]),
            new OA\Property(property: "insuranceApplicationSecurityQuestionType", type: "string", enum: [
                "FIRST_JOB_CITY_OR_TOWN",
                "FAVORITE_HIGH_SCHOOL_TEACHER_LAST_NAME",
                "OLDEST_CHILD_MIDDLE_NAME",
                "CHILDHOOD_NICKNAME"
            ], description: "The selected security question provided by the application contact."),
            new OA\Property(property: "insuranceApplicationSecurityQuestionAnswer", type: "string", description: "The answer to the selected security question provided by the application contact."),
            new OA\Property(property: "applicationSignatures", type: "array", items: new OA\Items(
                type: "object",
                required: ["type", "date", "status"],
                properties: [
                    new OA\Property(property: "type", type: "string", description: "The type of signature provided."),
                    new OA\Property(property: "date", type: "string", description: "The date the signature was provided."),
                    new OA\Property(property: "status", type: "string", description: "The status of the signature.")
                ]
            ), description: "The list of signatures for the application."),
            new OA\Property(property: "applicationAssistors", type: "array", items: new OA\Items(
                type: "object",
                required: ["type", "id"],
                properties: [
                    new OA\Property(property: "type", type: "string", description: "The type of assistor."),
                    new OA\Property(property: "id", type: "string", description: "The identifier for the assistor.")
                ]
            ), description: "Information on individual(s) that assist a member with their insurance application."),
            new OA\Property(property: "requestingFinancialAssistanceIndicator", type: "boolean", description: "Indicates whether the member(s) on the application is/are applying for financial assistance."),
            new OA\Property(property: "contactMemberIdentifier", type: "string", description: "The application member ID of the application contact."),
            new OA\Property(property: "contactMethod", type: "array", items: new OA\Items(
                type: "string"
            ), nullable: true, description: "Defines the association between the application contact and his/her preferred contact methods."),
            new OA\Property(property: "contactInformation", type: "object", required: ["primaryPhoneNumber"], properties: [
                new OA\Property(property: "email", type: "string", nullable: true, description: "Indicates the full text of an e-mail address."),
                new OA\Property(property: "primaryPhoneNumber", type: "object", required: ["type", "number"], properties: [
                    new OA\Property(property: "type", type: "string", enum: ["HOME", "WORK", "MOBILE"], description: "The type of phone number."),
                    new OA\Property(property: "number", type: "string", description: "Phone Number."),
                    new OA\Property(property: "ext", type: "string", nullable: true, description: "Phone Extension. Max length 6 digits")
                ]),
                new OA\Property(property: "secondaryPhoneNumber", type: "object", nullable: true, properties: [
                    new OA\Property(property: "type", type: "string", enum: ["HOME", "WORK", "MOBILE"], description: "The type of phone number."),
                    new OA\Property(property: "number", type: "string", nullable: true, description: "Phone Number."),
                    new OA\Property(property: "ext", type: "string", nullable: true, description: "Phone Extension. Max length 6 digits")
                ]),
                new OA\Property(property: "mobileNotificationPhoneNumber", type: "string", nullable: true, description: "Household contact's mobile notification phone number.")
            ]),
            new OA\Property(property: "spokenLanguageType", type: "string", enum: [
                "ENGLISH", "SPANISH", "VIETNAMESE", "TAGALOG", "RUSSIAN", "PORTUGUESE", "ARABIC", "CHINESE", "FRENCH", "FRENCH_CREOLE", "GERMAN", "GUJARATI", "HINDI", "KOREAN", "POLISH", "URDU", "OTHER"
            ], description: "The primary language the household contact speaks."),
            new OA\Property(property: "writtenLanguageType", type: "string", enum: [
                "ENGLISH", "SPANISH", "VIETNAMESE", "TAGALOG", "RUSSIAN", "PORTUGUESE", "ARABIC", "CHINESE", "FRENCH", "FRENCH_CREOLE", "GERMAN", "GUJARATI", "HINDI", "KOREAN", "POLISH", "URDU", "OTHER"
            ], description: "The primary language the household contact writes in."),
            new OA\Property(property: "coverageState", type: "string", enum: [
                "AK", "AL", "AR", "AS", "AZ", "CA", "CO", "CT", "DC", "DE", "FL", "FM", "GA", "GU", "HI", "IA", "ID", "IL", "IN", "KS", "KY", "LA", "MA", "MD", "ME", "MH", "MI", "MN", "MO", "MP", "MS", "MT", "NC", "ND", "NE", "NH", "NJ", "NM", "NV", "NY", "OH", "OK", "OR", "PA", "PR", "PW", "RI", "SC", "SD", "TN", "TX", "UM", "UT", "VA", "VI", "VT", "WA", "WI", "WV", "WY"
            ], description: "The state for which the application is being updated."),
            new OA\Property(property: "comments", type: "string", nullable: true, description: "Open text area for requestor to store specific comments in the application."),
            new OA\Property(property: "accountHolderIdentityProofedIndicator", type: "boolean", description: "Indicates whether the account holder is identity proofed or not.")
        ]),
        new OA\Property(property: "household", type: "object", required: ["familyRelationships", "legalRelationships", "taxRelationships"], properties: [
            new OA\Property(property: "familyRelationships", type: "array", items: new OA\Items(
                type: "object",
                required: ["type", "memberA", "memberB"],
                properties: [
                    new OA\Property(property: "type", type: "string", description: "The type of relationship."),
                    new OA\Property(property: "memberA", type: "string", description: "The ID of the first member."),
                    new OA\Property(property: "memberB", type: "string", description: "The ID of the second member.")
                ]
            ), description: "The family relationships between members on the application."),
            new OA\Property(property: "legalRelationships", type: "array", items: new OA\Items(
                type: "object",
                required: ["type", "memberA", "memberB"],
                properties: [
                    new OA\Property(property: "type", type: "string", description: "The type of relationship."),
                    new OA\Property(property: "memberA", type: "string", description: "The ID of the first member."),
                    new OA\Property(property: "memberB", type: "string", description: "The ID of the second member.")
                ]
            ), description: "The legal relationships between members on the application."),
            new OA\Property(property: "taxRelationships", type: "array", items: new OA\Items(
                type: "object",
                required: ["type", "memberA", "memberB"],
                properties: [
                    new OA\Property(property: "type", type: "string", description: "The type of relationship."),
                    new OA\Property(property: "memberA", type: "string", description: "The ID of the first member."),
                    new OA\Property(property: "memberB", type: "string", description: "The ID of the second member.")
                ]
            ), description: "The tax relationships between members on the application.")
        ]),
        new OA\Property(property: "members", type: "object", description: "This section covers member level attestations. This section should be a map of unique member IDs."),
        new OA\Property(property: "removedMembers", type: "object", description: "This section lists the members that have been removed from the application.")
    ]
)]
class UpdateApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'application' => 'required|array',
            'application.legalAttestations.absentParentAgreementIndicator' => 'required|boolean',
            'application.legalAttestations.changeInformationAgreementIndicator' => 'required|boolean',
            'application.legalAttestations.medicaidRequirementAgreementIndicator' => 'required|boolean',
            'application.legalAttestations.renewEligibilityYearQuantity' => 'required|numeric',
            'application.legalAttestations.nonIncarcerationAgreementIndicator' => 'required|boolean',
            'application.legalAttestations.penaltyOfPerjuryAgreementIndicator' => 'required|boolean',
            'application.legalAttestations.renewalAgreementIndicator' => 'required|boolean',
            'application.legalAttestations.terminateCoverageOtherMecFoundAgreementIndicator' => 'required|boolean',
            'application.insuranceApplicationSecurityQuestionType' => 'required|string',
            'application.insuranceApplicationSecurityQuestionAnswer' => 'required|string',
            'application.applicationSignatures' => 'required|array',
            'application.applicationAssistors' => 'nullable|array',
            'application.requestingFinancialAssistanceIndicator' => 'required|boolean',
            'application.contactMemberIdentifier' => 'required|string',
            'application.contactInformation.primaryPhoneNumber.type' => 'required|string',
            'application.contactInformation.primaryPhoneNumber.number' => 'required|string',
            'application.contactInformation.primaryPhoneNumber.ext' => 'nullable|string',
            'application.contactInformation.secondaryPhoneNumber.type' => 'nullable|string',
            'application.contactInformation.secondaryPhoneNumber.number' => 'nullable|string',
            'application.contactInformation.secondaryPhoneNumber.ext' => 'nullable|string',
            'application.contactInformation.mobileNotificationPhoneNumber' => 'nullable|string',
            'application.spokenLanguageType' => 'required|string',
            'application.writtenLanguageType' => 'required|string',
            'application.coverageState' => 'required|string',
            'application.comments' => 'nullable|string',
            'application.accountHolderIdentityProofedIndicator' => 'required|boolean',
            'household.familyRelationships' => 'required|array',
            'household.legalRelationships' => 'required|array',
            'household.taxRelationships' => 'required|array',
            'members' => 'required|array',
            'removedMembers' => 'required|array',
        ];
    }
}