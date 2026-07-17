<?php

namespace NetworkRailBusinessSystems\OrgPlus;

/**
 * @property array<string, OrganisationUnit> $children
 * @property ?CostCentre $costCentre
 * @property array<string, OrganisationUnit> $parents
 * @property array<string, Person> $people
 * @property array<string, Upn> $upns
 */
class OrganisationUnit extends OrgPlusModel
{
    public const array CAST_MAP = [
        self::REQUIRED_KEY => 'string',
    ];

    public const array FIELD_MAP = [
        self::REQUIRED_KEY => 'name',
    ];

    public const string REQUIRED_KEY = 'ORG';

    public const string KEY_FIELD = 'name';

    // Fields
    public string $name = '';

    // Relations
    public ?CostCentre $costCentre = null;

    public array $upns = [];

    public array $people = [];

    public function addCostCentre(?CostCentre $costCentre): void
    {
        $this->addRelation($costCentre, 'costCentre');
    }

    public function addPerson(?Person $person): void
    {
        $this->addRelation($person, 'people');
    }

    public function addUpn(?Upn $upn): void
    {
        $this->addRelation($upn, 'upns');
    }

    public function matchWithParent(array $library = []): void
    {
        foreach ($this->upns as $upn) {
            foreach ($upn->parents as $parent) {
                if (
                    $parent->organisationUnit !== null
                    && $parent->organisationUnit->name !== $this->name
                ) {
                    $this->addParent($parent->organisationUnit);
                    $parent->organisationUnit->addChild($this);
                }
            }
        }
    }
}
