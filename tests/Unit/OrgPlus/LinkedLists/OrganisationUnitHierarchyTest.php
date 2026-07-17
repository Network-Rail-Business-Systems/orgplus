<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\LinkedLists;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class OrganisationUnitHierarchyTest extends TestCase
{
    protected array $list;

    protected OrgPlus $orgPlus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orgPlus = OrgPlus::import(
            base_path('/tests/Data/hierarchy.csv'),
        );

        $this->list = $this->orgPlus->organisationUnitHierarchy();
    }

    public function test(): void
    {
        $this->assertEquals(
            [
                'Aaa' => [
                    'Bbb' => [
                        'Ccc' => [],
                    ],
                    'Ddd' => [
                        'Eee' => [],
                    ],
                ],
            ],
            $this->list,
        );
    }
}
