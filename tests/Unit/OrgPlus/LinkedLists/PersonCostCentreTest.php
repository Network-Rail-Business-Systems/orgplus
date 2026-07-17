<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\LinkedLists;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class PersonCostCentreTest extends TestCase
{
    protected array $list;

    protected OrgPlus $orgPlus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orgPlus = OrgPlus::import(
            base_path('/tests/Data/hierarchy.csv'),
        );

        $this->list = $this->orgPlus->personCostCentre();
    }

    public function test(): void
    {
        $this->assertEquals(
            [
                'a@b.com' => 12345,
                'b@c.com' => 12345,
                'c@d.com' => 12345,
                'd@e.com' => 23456,
                'e@f.com' => 23456,
                'f@g.com' => 45678,
                'g@h.com' => 34567,
                'h@i.com' => 34567,
                'i@j.com' => 56789,
            ],
            $this->list,
        );
    }
}
