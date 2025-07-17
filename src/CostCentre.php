<?php

namespace NetworkRailBusinessSystems\OrgPlus;

/**
 * @property array<string, CostCentre> $children
 * @property ?CostCentre $parent
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

    // Fields
    public ?int $code = null;

    // Relations
    public array $people = [];

    public array $upns = [];
}
