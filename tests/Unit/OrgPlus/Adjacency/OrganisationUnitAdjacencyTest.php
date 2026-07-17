<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\Adjacency;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class OrganisationUnitAdjacencyTest extends TestCase
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
                'Aaa' => '/Aaa',
                'Bbb' => '/Aaa/Bbb',
                'Ccc' => '/Aaa/Bbb/Ccc',
                'Ddd' => '/Aaa/Ddd',
                'Eee' => '/Aaa/Ddd/Eee',
            ],
            $this->orgPlus->organisationUnitAdjacency(),
        );
    }
}
