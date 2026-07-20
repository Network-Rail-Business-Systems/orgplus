<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\Adjacency;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class PersonAdjacencyTest extends TestCase
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
                'a@b.com' => '/a@b.com',
                'b@c.com' => '/a@b.com/b@c.com',
                'd@e.com' => '/a@b.com/c@d.com/d@e.com',
                'e@f.com' => '/a@b.com/c@d.com/d@e.com/e@f.com',
                'f@g.com' => '/a@b.com/c@d.com/d@e.com/e@f.com/f@g.com',
                'g@h.com' => '/a@b.com/c@d.com/g@h.com',
                'h@i.com' => '/a@b.com/c@d.com/g@h.com/h@i.com',
                'i@j.com' => '/a@b.com/c@d.com/g@h.com/h@i.com/i@j.com',
                'c@d.com' => '/a@b.com/c@d.com',
            ],
            $this->orgPlus->personAdjacency(),
        );
    }
}
