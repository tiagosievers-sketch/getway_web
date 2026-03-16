<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'CreateApplicationRequest',
    required: ['application', 'applicationMembers'],
    properties: [
        new OA\Property(
            property: "application",
            required: ["coverageYear", "coverageState", "linkedSystemUserIdentifier"],
            properties: [
                new OA\Property(property: "coverageYear", description: "The year for which the member(s) on the application is/are applying for coverage.", type: "number"),
                new OA\Property(property: "coverageState", description: "The state in which the application is applying.", type: "string", enum: ["AK", "AL", "AR", "AS", "AZ", "CA", "CO", "CT", "DC", "DE", "FL", "FM", "GA", "GU", "HI", "IA", "ID", "IL", "IN", "KS", "KY", "LA", "MA", "MD", "ME", "MH", "MI", "MN", "MO", "MP", "MS", "MT", "NC", "ND", "NE", "NH", "NJ", "NM", "NV", "NY", "OH", "OK", "OR", "PA", "PR", "PW", "RI", "SC", "SD", "TN", "TX", "UM", "UT", "VA", "VI", "VT", "WA", "WI", "WV", "WY"]),
                new OA\Property(property: "comments", description: "Open text area for requestor to store specific comments in the application.", type: "string", nullable: true),
                new OA\Property(property: "linkedSystemUserIdentifier", description: "The systemUser identifier from legacy.", type: "string"),
                new OA\Property(property: "contactMethod", description: "Defines the association between the application contact and his/her preferred contact methods.", type: "array", items: new OA\Items(ref:'#/components/schemas/CostSharing') /**TODO CRIAR O COMPONENTE DE ITENS AQUI**/),
                new OA\Property(
                    property: "contactInformation",
                    required: ["primaryPhoneNumber"],
                    properties: [
                        new OA\Property(property: "email", description: "Indicates the full text of an e-mail address.", type: "string", nullable: true),
                        new OA\Property(
                            property: "primaryPhoneNumber",
                            required: ["type", "number"],
                            properties: [
                                new OA\Property(property: "type", description: "The type of phone number.", type: "string", enum: ["HOME", "WORK", "MOBILE"]),
                                new OA\Property(property: "number", description: "Phone Number.", type: "string"),
                                new OA\Property(property: "ext", description: "Phone Extension. Max length 6 digits.", type: "string", nullable: true)
                            ],
                            type: "object"
                        ),
                        new OA\Property(
                            property: "secondaryPhoneNumber",
                            properties: [
                                new OA\Property(property: "type", description: "The type of phone number.", type: "string", enum: ["HOME", "WORK", "MOBILE"]),
                                new OA\Property(property: "number", description: "Phone Number.", type: "string"),
                                new OA\Property(property: "ext", description: "Phone Extension. Max length 6 digits.", type: "string", nullable: true)
                            ],
                            type: "object",
                            nullable: true
                        ),
                        new OA\Property(property: "mobileNotificationPhoneNumber", description: "Household contact's mobile notification phone number.", type: "string", nullable: true)
                    ],
                    type: "object"
                )
            ],
            type: "object"
        ),
        new OA\Property(
            property: "applicationMembers",
            description: "One or more member can be created on the newly created application",
            type: "array",
            items: new OA\Items(
                required: ["householdContactIndicator", "firstName", "lastName", "birthDate"],
                properties: [
                    new OA\Property(property: "householdContactIndicator", description: "Indicates whether the application member is the household contact.", type: "boolean"),
                    new OA\Property(property: "firstName", description: "First name of the member.", type: "string"),
                    new OA\Property(property: "middleName", description: "Indicates the person's legal middle name or the person's legal middle initial.", type: "string", nullable: true),
                    new OA\Property(property: "lastName", description: "Last name of the member.", type: "string"),
                    new OA\Property(property: "suffix", description: "Indicates the personnel's last name suffix.", type: "string", enum: ["Jr.", "Sr.", "II", "III", "IV", "V"], nullable: true),
                    new OA\Property(property: "birthDate", description: "Member's attested birth date.", type: "string"),
                    new OA\Property(property: "noHomeAddressIndicator", description: "Indicates whether a member does not have a fixed address.", type: "boolean", nullable: true),
                    new OA\Property(property: "liveOutsideStateTemporarilyIndicator", description: "Indicates whether this application member attests to living outside of the state temporarily.", type: "boolean", nullable: true),
                    new OA\Property(
                        property: "mailingAddress",
                        required: ["streetName1", "cityName", "stateCode", "zipCode"],
                        properties: [
                            new OA\Property(property: "streetName1", description: "The first line of the street address.", type: "string"),
                            new OA\Property(property: "streetName2", description: "The second line of the street address.", type: "string", nullable: true),
                            new OA\Property(property: "cityName", description: "The name of the city where the address is located.", type: "string"),
                            new OA\Property(property: "stateCode", description: "A specific textual value intended to capture business meaning.", type: "string", enum: ["AK", "AL", "AR", "AS", "AZ", "CA", "CO", "CT", "DC", "DE", "FL", "FM", "GA", "GU", "HI", "IA", "ID", "IL", "IN", "KS", "KY", "LA", "MA", "MD", "ME", "MH", "MI", "MN", "MO", "MP", "MS", "MT", "NC", "ND", "NE", "NH", "NJ", "NM", "NV", "NY", "OH", "OK", "OR", "PA", "PR", "PW", "RI", "SC", "SD", "TN", "TX", "UM", "UT", "VA", "VI", "VT", "WA", "WI", "WV", "WY"]),
                            new OA\Property(property: "plus4Code", description: "The +4 code used in addition to zipCodes.", type: "string", nullable: true),
                            new OA\Property(property: "zipCode", description: "A specific value intended to capture the USPS identifier for a geographic area within a state.", type: "string"),
                            new OA\Property(property: "countyName", description: "County Name.", type: "string", nullable: true),
                            new OA\Property(property: "countyFipsCode", description: "County Fips Code.", type: "string", nullable: true)
                        ],
                        type: "object",
                        nullable: true
                    ),
                    new OA\Property(
                        property: "homeAddress",
                        required: ["streetName1", "cityName", "stateCode", "zipCode"],
                        properties: [
                            new OA\Property(property: "streetName1", description: "The first line of the street address.", type: "string"),
                            new OA\Property(property: "streetName2", description: "The second line of the street address.", type: "string", nullable: true),
                            new OA\Property(property: "cityName", description: "The name of the city where the address is located.", type: "string"),
                            new OA\Property(property: "stateCode", description: "A specific textual value intended to capture business meaning.", type: "string", enum: ["AK", "AL", "AR", "AS", "AZ", "CA", "CO", "CT", "DC", "DE", "FL", "FM", "GA", "GU", "HI", "IA", "ID", "IL", "IN", "KS", "KY", "LA", "MA", "MD", "ME", "MH", "MI", "MN", "MO", "MP", "MS", "MT", "NC", "ND", "NE", "NH", "NJ", "NM", "NV", "NY", "OH", "OK", "OR", "PA", "PR", "PW", "RI", "SC", "SD", "TN", "TX", "UM", "UT", "VA", "VI", "VT", "WA", "WI", "WV", "WY"]),
                            new OA\Property(property: "plus4Code", description: "The +4 code used in addition to zipCodes.", type: "string", nullable: true),
                            new OA\Property(property: "zipCode", description: "A specific value intended to capture the USPS identifier for a geographic area within a state.", type: "string"),
                            new OA\Property(property: "countyName", description: "County Name.", type: "string", nullable: true),
                            new OA\Property(property: "countyFipsCode", description: "County Fips Code.", type: "string", nullable: true)
                        ],
                        type: "object",
                        nullable: true
                    ),
                    new OA\Property(
                        property: "transientAddress",
                        required: ["streetName1", "cityName", "stateCode", "zipCode"],
                        properties: [
                            new OA\Property(property: "streetName1", description: "The first line of the street address.", type: "string"),
                            new OA\Property(property: "streetName2", description: "The second line of the street address.", type: "string", nullable: true),
                            new OA\Property(property: "cityName", description: "The name of the city where the address is located.", type: "string"),
                            new OA\Property(property: "stateCode", description: "A specific textual value intended to capture business meaning.", type: "string", enum: ["AK", "AL", "AR", "AS", "AZ", "CA", "CO", "CT", "DC", "DE", "FL", "FM", "GA", "GU", "HI", "IA", "ID", "IL", "IN", "KS", "KY", "LA", "MA", "MD", "ME", "MH", "MI", "MN", "MO", "MP", "MS", "MT", "NC", "ND", "NE", "NH", "NJ", "NM", "NV", "NY", "OH", "OK", "OR", "PA", "PR", "PW", "RI", "SC", "SD", "TN", "TX", "UM", "UT", "VA", "VI", "VT", "WA", "WI", "WV", "WY"]),
                            new OA\Property(property: "plus4Code", description: "The +4 code used in addition to zipCodes.", type: "string", nullable: true),
                            new OA\Property(property: "zipCode", description: "A specific value intended to capture the USPS identifier for a geographic area within a state.", type: "string"),
                            new OA\Property(property: "countyName", description: "County Name.", type: "string", nullable: true),
                            new OA\Property(property: "countyFipsCode", description: "County Fips Code.", type: "string", nullable: true)
                        ],
                        type: "object",
                        nullable: true
                    )
                ],
                type: "object"
            )
        )
    ]
)]
class CreateApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'application' => 'required|array',
            'application.coverageYear' => 'required|integer',
            'application.coverageState' => 'required|string|in:AK,AL,AR,AS,AZ,CA,CO,CT,DC,DE,FL,FM,GA,GU,HI,IA,ID,IL,IN,KS,KY,LA,MA,MD,ME,MH,MI,MN,MO,MP,MS,MT,NC,ND,NE,NH,NJ,NM,NV,NY,OH,OK,OR,PA,PR,PW,RI,SC,SD,TN,TX,UM,UT,VA,VI,VT,WA,WI,WV,WY',
            'application.comments' => 'nullable|string',
            'application.linkedSystemUserIdentifier' => 'required|string',
            'application.contactMethod' => 'nullable|array',
            'application.contactInformation' => 'nullable|array',
            'application.contactInformation.email' => 'nullable|email',
            'application.contactInformation.primaryPhoneNumber.type' => 'required|string|in:HOME,WORK,MOBILE',
            'application.contactInformation.primaryPhoneNumber.number' => 'required|string',
            'application.contactInformation.primaryPhoneNumber.ext' => 'nullable|string|max:6',
            'application.contactInformation.secondaryPhoneNumber.type' => 'nullable|string|in:HOME,WORK,MOBILE',
            'application.contactInformation.secondaryPhoneNumber.number' => 'nullable|string',
            'application.contactInformation.secondaryPhoneNumber.ext' => 'nullable|string|max:6',
            'application.contactInformation.mobileNotificationPhoneNumber' => 'nullable|string',

            'applicationMembers' => 'required|array',
            'applicationMembers.*.householdContactIndicator' => 'required|boolean',
            'applicationMembers.*.firstName' => 'required|string',
            'applicationMembers.*.middleName' => 'nullable|string',
            'applicationMembers.*.lastName' => 'required|string',
            'applicationMembers.*.suffix' => 'nullable|string|in:Jr.,Sr.,II,III,IV,V',
            'applicationMembers.*.birthDate' => 'required|date_format:Y-m-d',
            'applicationMembers.*.noHomeAddressIndicator' => 'nullable|boolean',
            'applicationMembers.*.liveOutsideStateTemporarilyIndicator' => 'nullable|boolean',
            'applicationMembers.*.mailingAddress.streetName1' => 'required_if:applicationMembers.*.householdContactIndicator,true|string',
            'applicationMembers.*.mailingAddress.streetName2' => 'nullable|string',
            'applicationMembers.*.mailingAddress.cityName' => 'required_if:applicationMembers.*.householdContactIndicator,true|string',
            'applicationMembers.*.mailingAddress.stateCode' => 'required_if:applicationMembers.*.householdContactIndicator,true|string|in:AK,AL,AR,AS,AZ,CA,CO,CT,DC,DE,FL,FM,GA,GU,HI,IA,ID,IL,IN,KS,KY,LA,MA,MD,ME,MH,MI,MN,MO,MP,MS,MT,NC,ND,NE,NH,NJ,NM,NV,NY,OH,OK,OR,PA,PR,PW,RI,SC,SD,TN,TX,UM,UT,VA,VI,VT,WA,WI,WV,WY',
            'applicationMembers.*.mailingAddress.zipCode' => 'required_if:applicationMembers.*.householdContactIndicator,true|string',
            'applicationMembers.*.mailingAddress.plus4Code' => 'nullable|string',
            'applicationMembers.*.mailingAddress.countyName' => 'nullable|string',
            'applicationMembers.*.mailingAddress.countyFipsCode' => 'nullable|string',
            'applicationMembers.*.homeAddress.streetName1' => 'required_if:applicationMembers.*.noHomeAddressIndicator,false|string',
            'applicationMembers.*.homeAddress.streetName2' => 'nullable|string',
            'applicationMembers.*.homeAddress.cityName' => 'required_if:applicationMembers.*.noHomeAddressIndicator,false|string',
            'applicationMembers.*.homeAddress.stateCode' => 'required_if:applicationMembers.*.noHomeAddressIndicator,false|string|in:AK,AL,AR,AS,AZ,CA,CO,CT,DC,DE,FL,FM,GA,GU,HI,IA,ID,IL,IN,KS,KY,LA,MA,MD,ME,MH,MI,MN,MO,MP,MS,MT,NC,ND,NE,NH,NJ,NM,NV,NY,OH,OK,OR,PA,PR,PW,RI,SC,SD,TN,TX,UM,UT,VA,VI,VT,WA,WI,WV,WY',
            'applicationMembers.*.homeAddress.zipCode' => 'required_if:applicationMembers.*.noHomeAddressIndicator,false|string',
            'applicationMembers.*.homeAddress.plus4Code' => 'nullable|string',
            'applicationMembers.*.homeAddress.countyName' => 'nullable|string',
            'applicationMembers.*.homeAddress.countyFipsCode' => 'nullable|string',
            'applicationMembers.*.transientAddress.streetName1' => 'required_if:applicationMembers.*.liveOutsideStateTemporarilyIndicator,true|string',
            'applicationMembers.*.transientAddress.streetName2' => 'nullable|string',
            'applicationMembers.*.transientAddress.cityName' => 'required_if:applicationMembers.*.liveOutsideStateTemporarilyIndicator,true|string',
            'applicationMembers.*.transientAddress.stateCode' => 'required_if:applicationMembers.*.liveOutsideStateTemporarilyIndicator,true|string|in:AK,AL,AR,AS,AZ,CA,CO,CT,DC,DE,FL,FM,GA,GU,HI,IA,ID,IL,IN,KS,KY,LA,MA,MD,ME,MH,MI,MN,MO,MP,MS,MT,NC,ND,NE,NH,NJ,NM,NV,NY,OH,OK,OR,PA,PR,PW,RI,SC,SD,TN,TX,UM,UT,VA,VI,VT,WA,WI,WV,WY',
            'applicationMembers.*.transientAddress.zipCode' => 'required_if:applicationMembers.*.liveOutsideStateTemporarilyIndicator,true|string',
            'applicationMembers.*.transientAddress.plus4Code' => 'nullable|string',
            'applicationMembers.*.transientAddress.countyName' => 'nullable|string',
            'applicationMembers.*.transientAddress.countyFipsCode' => 'nullable|string'
        ];
    }
}
