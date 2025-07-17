<?php

namespace NetworkRailBusinessSystems\OrgPlus;

/**
 * @property array<string, Upn> $children
 * @property ?Upn $parent
 * @property array<string, Person> $people
 */
class Upn extends OrgPlusModel
{
    public const array CAST_MAP = [
        'A2C_LIMIT' => 'int',
        'A2I_LIMIT' => 'int',
        'A2V_LIMIT' => 'int',
        'AREA' => 'string',
        'ASSET_GROUP' => 'string',
        'COST_CENTRE_OWNER' => 'bool',
        'FUNCTION' => 'string',
        'GRADE' => 'string',
        'JOB' => 'string',
        'JOB_TITLE' => 'string',
        'LOCATION' => 'string',
        'ORG' => 'string',
        'ORG_HR_MANAGER' => 'string',
        'PARENT_JOB_TITLE' => 'string',
        'PARENT_NAME' => 'string',
        'PARENT_UPN' => 'string',
        'POSITION_NAME' => 'string',
        'POSITION_TYPE' => 'string',
        'POST_DISCIPLINE' => 'string',
        'POS_CHART_NUMBER' => 'string',
        'POS_JOB_REQUIREMENT_CAR' => 'bool',
        'QUALIFIER' => 'string',
        'ROUTE' => 'string',
        'TERRITORY' => 'string',
        'UPN' => 'string',
    ];

    public const array FIELD_MAP = [
        'A2C_LIMIT' => 'authorityToContractLimit',
        'A2I_LIMIT' => 'authorityToIncurLimit',
        'A2V_LIMIT' => 'authorityToVaryLimit',
        'AREA' => 'area',
        'ASSET_GROUP' => 'assetGroup',
        'COST_CENTRE_OWNER' => 'costCentreOwner',
        'FUNCTION' => 'function',
        'GRADE' => 'grade',
        'JOB' => 'job',
        'JOB_TITLE' => 'jobTitle',
        'LOCATION' => 'location',
        'ORG' => 'org',
        'ORG_HR_MANAGER' => 'orgHrManager',
        'PARENT_JOB_TITLE' => 'parentJobTitle',
        'PARENT_NAME' => 'parentName',
        'PARENT_UPN' => 'parentUpn',
        'POSITION_NAME' => 'positionName',
        'POSITION_TYPE' => 'positionType',
        'POST_DISCIPLINE' => 'postDiscipline',
        'POS_CHART_NUMBER' => 'posChartNumber',
        'POS_JOB_REQUIREMENT_CAR' => 'requiresCar',
        'QUALIFIER' => 'qualifier',
        'ROUTE' => 'route',
        'TERRITORY' => 'territory',
        'UPN' => 'code',
    ];

    // Fields
    public ?string $area = null;

    public ?string $assetGroup = null;

    public ?int $authorityToContractLimit = null;

    public ?int $authorityToIncurLimit = null;

    public ?int $authorityToVaryLimit = null;

    public ?string $code = null;

    public bool $costCentreOwner = false;

    public ?string $function = null;

    public ?string $grade = null;

    public ?string $job = null;

    public ?string $jobTitle = null;

    public ?string $location = null;

    public ?string $org = null;

    public ?string $orgHrManager = null;

    public ?string $parentJobTitle = null;

    public ?string $parentName = null;

    public ?string $parentUpn = null;

    public ?string $posChartNumber = null;

    public ?string $positionName = null;

    public ?string $positionType = null;

    public ?string $postDiscipline = null;

    public ?string $qualifier = null;

    public bool $requiresCar = false;

    public ?string $route = null;

    public ?string $territory = null;

    // Relations
    public ?CostCentre $costCentre = null;

    public array $people = [];
}
