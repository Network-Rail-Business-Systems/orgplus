<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\LinkedLists;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class PersonParentsTest extends TestCase
{
    protected array $list;

    protected OrgPlus $orgPlus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orgPlus = OrgPlus::import(
            base_path('/tests/Data/hierarchy.csv'),
        );

        $this->list = $this->orgPlus->personParents();
    }

    public function test(): void
    {
        $this->assertEquals(
            [
                'b@c.com',
                'c@d.com',
            ],
            $this->list['d@e.com'],
        );
    }
}
