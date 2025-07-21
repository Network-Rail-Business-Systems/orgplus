<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\LinkedLists;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class MakeHierarchyTest extends TestCase
{
    protected array $list;

    protected OrgPlus $orgPlus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orgPlus = OrgPlus::import(
            base_path('/tests/Data/hierarchy.csv'),
        );

        $this->list = $this->orgPlus->makeHierarchy($this->orgPlus->upns);
    }

    public function test(): void
    {
        $this->assertEquals(
            [
                'A123' => [
                    'A234' => [
                        'A345' => [
                            'A456' => [
                                'A567' => [],
                            ],
                        ],
                        'A678' => [
                            'A789' => [
                                'A890' => [],
                            ],
                        ],
                    ],
                ],
            ],
            $this->list,
        );
    }
}
