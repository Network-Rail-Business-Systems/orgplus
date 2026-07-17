<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\Adjacency;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class CostCentreAdjacencyTest extends TestCase
{
    protected OrgPlus $orgPlus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orgPlus = OrgPlus::import(
            base_path('/tests/Data/hierarchy.csv'),
        );
    }

    public function test(): void
    {
        $this->assertEquals(
            [
                12345 => '/12345',
                23456 => '/12345/23456',
                45678 => '/12345/23456/45678',
                34567 => '/12345/34567',
                56789 => '/12345/34567/56789',
            ],
            $this->orgPlus->costCentreAdjacency(),
        );
    }
}
