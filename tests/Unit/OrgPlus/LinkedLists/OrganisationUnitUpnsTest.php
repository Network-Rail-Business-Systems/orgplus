<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\LinkedLists;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class OrganisationUnitUpnsTest extends TestCase
{
    protected array $list;

    protected OrgPlus $orgPlus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orgPlus = OrgPlus::import(
            base_path('/tests/Data/hierarchy.csv'),
        );

        $this->list = $this->orgPlus->organisationUnitUpns();
    }

    public function test(): void
    {
        $this->assertEquals(
            [
                'Aaa' => [
                    'A123',
                    'A234',
                ],
                'Bbb' => [
                    'A345',
                    'A456',
                ],
                'Ccc' => [
                    'A567',
                ],
                'Ddd' => [
                    'A678',
                    'A789',
                ],
                'Eee' => [
                    'A890',
                ],
            ],
            $this->list,
        );
    }
}
