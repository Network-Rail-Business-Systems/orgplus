<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\LinkedLists;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class CostCentreOrganisationUnitsTest extends TestCase
{
    protected array $list;

    protected OrgPlus $orgPlus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orgPlus = OrgPlus::import(
            base_path('/tests/Data/hierarchy.csv'),
        );

        $this->list = $this->orgPlus->costCentreOrganisationUnits();
    }

    public function test(): void
    {
        $this->assertEquals(
            [
                12345 => [
                    'Aaa',
                ],
                23456 => [
                    'Bbb',
                ],
                45678 => [
                    'Ccc',
                ],
                34567 => [
                    'Ddd',
                ],
                56789 => [
                    'Eee',
                ],
            ],
            $this->list,
        );
    }
}
