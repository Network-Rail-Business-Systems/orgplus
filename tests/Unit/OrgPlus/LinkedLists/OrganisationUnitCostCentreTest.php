<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\LinkedLists;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class OrganisationUnitCostCentreTest extends TestCase
{
    protected array $list;

    protected OrgPlus $orgPlus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orgPlus = OrgPlus::import(
            base_path('/tests/Data/hierarchy.csv'),
        );

        $this->list = $this->orgPlus->organisationUnitCostCentre();
    }

    public function test(): void
    {
        $this->assertEquals(
            [
                'Aaa' => 12345,
                'Bbb' => 23456,
                'Ccc' => 45678,
                'Ddd' => 34567,
                'Eee' => 56789,
            ],
            $this->list,
        );
    }
}
