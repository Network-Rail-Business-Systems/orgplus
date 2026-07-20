<?php

namespace NetworkRailBusinessSystems\OrgPlus;

/**
 * @property array<int, CostCentre> $children
 * @property array<string, OrganisationUnit> $organisationUnits
 * @property array<string, CostCentre> $parents
 * @property array<string, Person> $people
 * @property array<string, Upn> $upns
 */
class CostCentre extends OrgPlusModel
{
    public const array CAST_MAP = [
        self::REQUIRED_KEY => 'int',
    ];

    public const array FIELD_MAP = [
        self::REQUIRED_KEY => 'number',
    ];

    public const string REQUIRED_KEY = 'COST_CENTRE';

    public const string KEY_FIELD = 'number';

    // Fields
    public ?int $number = null;

    // Relations
    public array $organisationUnits = [];

    public array $upns = [];

    public array $people = [];

    public function addPerson(?Person $person): void
    {
        $this->addRelation($person, 'people');
    }

    public function addOrganisationUnit(?OrganisationUnit $organisationUnit): void
    {
        $this->addRelation($organisationUnit, 'organisationUnits');
    }

    public function addUpn(?Upn $upn): void
    {
        $this->addRelation($upn, 'upns');
    }

    public function matchWithParent(array $library = []): void
    {
        foreach ($this->upns as $upn) {
            foreach ($upn->parents as $parentUpn) {
                if ($parentUpn->costCentre?->number === null) {
                    continue;
                }

                if ($parentUpn->costCentre->number !== $this->number) {
                    $this->addParent($parentUpn->costCentre);
                    $parentUpn->costCentre->addChild($this);
                }
            }
        }
    }

    // Counts
    public function contents(): array
    {
        return $this->organisationUnits;
    }
}
