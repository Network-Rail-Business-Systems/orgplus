<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlusModel;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class ContentsChildrenCountTest extends TestCase
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
            6,
            $this->orgPlus->organisationUnits['Aaa']->contentsChildrenCount(),
        );

        $this->assertEquals(
            3,
            $this->orgPlus->organisationUnits['Bbb']->contentsChildrenCount(),
        );

        $this->assertEquals(
            1,
            $this->orgPlus->organisationUnits['Ccc']->contentsChildrenCount(),
        );

        $this->assertEquals(
            3,
            $this->orgPlus->organisationUnits['Ddd']->contentsChildrenCount(),
        );

        $this->assertEquals(
            1,
            $this->orgPlus->organisationUnits['Eee']->contentsChildrenCount(),
        );
    }
}
