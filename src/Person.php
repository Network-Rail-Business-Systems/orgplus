<?php

namespace NetworkRailBusinessSystems\OrgPlus;

/**
 * @property array<string, Person> $children
 * @property ?Person $parent
 */
class Person extends OrgPlusModel
{
    public const array CAST_MAP = [
        'EMAIL_ADDRESS' => 'string',
        'EMPLOYEE_NUMBER' => 'int',
        'FIRST_NAME' => 'string',
        'KNOWN_AS' => 'string',
        'LAST_NAME' => 'string',
        'LDAP_UID' => 'string',
        'NAME' => 'string',
        'PERSON_TYPE' => 'string',
        'PSE_NUMBER' => 'string',
    ];

    public const array FIELD_MAP = [
        'EMAIL_ADDRESS' => 'emailAddress',
        'EMPLOYEE_NUMBER' => 'employeeNumber',
        'FIRST_NAME' => 'firstName',
        'KNOWN_AS' => 'knownAs',
        'LAST_NAME' => 'lastName',
        'LDAP_UID' => 'ldapUid',
        'NAME' => 'name',
        'PERSON_TYPE' => 'personType',
        'PSE_NUMBER' => 'pseNumber',
    ];

    public const string REQUIRED_KEY = 'EMAIL_ADDRESS';

    // Fields
    public ?string $email = null;

    public ?int $employeeNumber = null;

    public ?string $firstName = null;

    public ?string $knownAs = null;

    public ?string $lastName = null;

    public ?string $ldapUid = null;

    public ?string $name = null;

    public ?string $personType = null;

    public ?string $pseNumber = null;

    // Relations
    public ?CostCentre $costCentre = null;

    public ?Upn $upn = null;
}
