<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\LinkedLists;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class MakeListTest extends TestCase
{
    protected OrgPlus $orgPlus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orgPlus = OrgPlus::import(
            base_path('/tests/Data/hierarchy.csv'),
        );
    }

    public function testWhenRelatedArray(): void
    {
        $this->assertEquals(
            [
                12345 => [
                    23456,
                    34567,
                ],
                23456 => [
                    45678,
                ],
                34567 => [
                    56789,
                ],
                45678 => [],
                56789 => [],
            ],
            $this->orgPlus->makeList($this->orgPlus->costCentres, 'code', 'children', 'code'),
        );
    }

    public function testWhenRelatedSingle(): void
    {
        $this->assertEquals(
            [
                'A123' => 12345,
                'A234' => 12345,
                'A345' => 23456,
                'A456' => 23456,
                'A567' => 45678,
                'A678' => 34567,
                'A789' => 34567,
                'A890' => 56789,
            ],
            $this->orgPlus->makeList($this->orgPlus->upns, 'code', 'costCentre', 'code'),
        );
    }
}
