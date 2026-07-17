<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\LinkedLists;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class PersonOrganisationUnitTest extends TestCase
{
    protected array $list;

    protected OrgPlus $orgPlus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orgPlus = OrgPlus::import(
            base_path('/tests/Data/hierarchy.csv'),
        );

        $this->list = $this->orgPlus->personOrganisationUnit();
    }

    public function test(): void
    {
        $this->assertEquals(
            [
                'a@b.com' => 'Aaa',
                'b@c.com' => 'Aaa',
                'c@d.com' => 'Aaa',
                'd@e.com' => 'Bbb',
                'e@f.com' => 'Bbb',
                'f@g.com' => 'Ccc',
                'g@h.com' => 'Ddd',
                'h@i.com' => 'Ddd',
                'i@j.com' => 'Eee',
            ],
            $this->list,
        );
    }
}
