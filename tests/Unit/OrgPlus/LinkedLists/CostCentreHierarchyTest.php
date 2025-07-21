<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\LinkedLists;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class CostCentreHierarchyTest extends TestCase
{
    protected array $list;

    protected OrgPlus $orgPlus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orgPlus = OrgPlus::import(
            base_path('/tests/Data/hierarchy.csv'),
        );

        $this->list = $this->orgPlus->costCentreHierarchy();
    }

    public function test(): void
    {
        $this->assertEquals(
            [
                12345 => [
                    23456 => [
                        45678 => [],
                    ],
                    34567 => [
                        56789 => [],
                    ],
                ],
            ],
            $this->list,
        );
    }
}
