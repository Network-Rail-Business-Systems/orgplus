<?php

namespace NetworkRailBusinessSystems\OrgPlus;

/**
 * @property array<int, CostCentre> $children
 * @property array<string, CostCentre> $parents
 * @property array<string, Person> $people
 * @property array<string, Upn> $upns
 */
class CostCentre extends OrgPlusModel
{
    public const array CAST_MAP = [
        'COST_CENTRE' => 'int',
    ];

    public const array FIELD_MAP = [
        'COST_CENTRE' => 'code',
    ];

    public const string REQUIRED_KEY = 'COST_CENTRE';

    public const string KEY_FIELD = 'code';

    // Fields
    public ?int $code = null;

    // Relations
    public array $people = [];

    public array $upns = [];

    public function addPerson(?Person $person): void
    {
        $this->addRelation($person, 'people');
    }

    public function addUpn(?Upn $upn): void
    {
        $this->addRelation($upn, 'upns');
    }

    /** @param array<string, OrgPlusModel> $library */
    public function matchWithParent(array $library = []): void
    {
        foreach ($this->upns as $upn) {
            foreach ($upn->parents as $parentUpn) {
                if ($parentUpn->costCentre?->code === null) {
                    continue;
                }

                if ($parentUpn->costCentre->code !== $this->code) {
                    $this->addParent($parentUpn->costCentre);
                    $parentUpn->costCentre->addChild($this);
                }
            }
        }
    }

    /**
     * @param array<string, CostCentre> $costCentres
     * @param array<string, Person> $people
     * @param array<string, Upn> $upns
     */
    public function matchWithRelated(array $costCentres, array $people, array $upns): void
    {
        //
    }
}
