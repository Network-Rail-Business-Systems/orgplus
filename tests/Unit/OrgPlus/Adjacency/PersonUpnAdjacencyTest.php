<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\Adjacency;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class PersonUpnAdjacencyTest extends TestCase
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
                'a@b.com' => '/A123',
                'b@c.com' => '/A123/A234',
                'd@e.com' => '/A123/A234/A345',
                'e@f.com' => '/A123/A234/A345/A456',
                'f@g.com' => '/A123/A234/A345/A456/A567',
                'g@h.com' => '/A123/A234/A678',
                'h@i.com' => '/A123/A234/A678/A789',
                'i@j.com' => '/A123/A234/A678/A789/A890',
                'c@d.com' => '/A123/A234',
            ],
            $this->orgPlus->personUpnAdjacency(),
        );
    }
}
