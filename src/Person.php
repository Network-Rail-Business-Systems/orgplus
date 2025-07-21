<?php

namespace NetworkRailBusinessSystems\OrgPlus;

/**
 * @property array<string, Person> $children
 * @property array<string, Person> $parents
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
        'EMAIL_ADDRESS' => 'email',
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

    public const string KEY_FIELD = 'email';

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

    public function addCostCentre(?CostCentre $costCentre): void
    {
        $this->addRelation($costCentre, 'costCentre');
    }

    public function addUpn(?Upn $upn): void
    {
        $this->addRelation($upn, 'upn');
    }

    public function matchWithParent(array $library = []): void
    {
        foreach ($this->upn->parents as $parentUpn) {
            foreach ($parentUpn->people as $parent) {
                $this->addParent($parent);
                $parent->addChild($this);
            }
        }
    }
}
