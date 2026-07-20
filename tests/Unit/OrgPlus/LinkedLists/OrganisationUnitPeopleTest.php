<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\LinkedLists;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class OrganisationUnitPeopleTest extends TestCase
{
    protected array $list;

    protected OrgPlus $orgPlus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orgPlus = OrgPlus::import(
            base_path('/tests/Data/hierarchy.csv'),
        );

        $this->list = $this->orgPlus->organisationUnitPeople();
    }

    public function test(): void
    {
        $this->assertEquals(
            [
                'Aaa' => [
                    'a@b.com',
                    'b@c.com',
                    'c@d.com',
                ],
                'Bbb' => [
                    'd@e.com',
                    'e@f.com',
                ],
                'Ccc' => [
                    'f@g.com',
                ],
                'Ddd' => [
                    'g@h.com',
                    'h@i.com',
                ],
                'Eee' => [
                    'i@j.com',
                ],
            ],
            $this->list,
        );
    }
}
