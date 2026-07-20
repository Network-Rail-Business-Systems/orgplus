<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\LinkedLists;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class UpnOrganisationUnitTest extends TestCase
{
    protected array $list;

    protected OrgPlus $orgPlus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orgPlus = OrgPlus::import(
            base_path('/tests/Data/hierarchy.csv'),
        );

        $this->list = $this->orgPlus->upnOrganisationUnit();
    }

    public function test(): void
    {
        $this->assertEquals(
            [
                'A123' => 'Aaa',
                'A234' => 'Aaa',
                'A345' => 'Bbb',
                'A456' => 'Bbb',
                'A567' => 'Ccc',
                'A678' => 'Ddd',
                'A789' => 'Ddd',
                'A890' => 'Eee',
            ],
            $this->list,
        );
    }
}
