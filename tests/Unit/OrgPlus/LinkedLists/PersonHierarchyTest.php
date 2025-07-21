<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\LinkedLists;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class PersonHierarchyTest extends TestCase
{
    protected array $list;

    protected OrgPlus $orgPlus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orgPlus = OrgPlus::import(
            base_path('/tests/Data/hierarchy.csv'),
        );

        $this->list = $this->orgPlus->personHierarchy();
    }

    public function test(): void
    {
        $this->assertEquals(
            [
                'a@b.com' => [
                    'b@c.com' => [
                        'd@e.com' => [
                            'e@f.com' => [
                                'f@g.com' => [],
                            ],
                        ],
                        'g@h.com' => [
                            'h@i.com' => [
                                'i@j.com' => [],
                            ],
                        ],
                    ],
                    'c@d.com' => [
                        'd@e.com' => [
                            'e@f.com' => [
                                'f@g.com' => [],
                            ],
                        ],
                        'g@h.com' => [
                            'h@i.com' => [
                                'i@j.com' => [],
                            ],
                        ],
                    ],
                ],
            ],
            $this->list,
        );
    }
}
