<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\Adjacency;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class UpnAdjacencyTest extends TestCase
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
                'A123' => '/A123',
                'A234' => '/A123/A234',
                'A345' => '/A123/A234/A345',
                'A456' => '/A123/A234/A345/A456',
                'A567' => '/A123/A234/A345/A456/A567',
                'A678' => '/A123/A234/A678',
                'A789' => '/A123/A234/A678/A789',
                'A890' => '/A123/A234/A678/A789/A890',
            ],
            $this->orgPlus->upnAdjacency(),
        );
    }
}
