<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlusModel;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class ContentsCountTest extends TestCase
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
            2,
            $this->orgPlus->organisationUnits['Aaa']->contentsCount(),
        );

        $this->assertEquals(
            2,
            $this->orgPlus->organisationUnits['Bbb']->contentsCount(),
        );

        $this->assertEquals(
            1,
            $this->orgPlus->organisationUnits['Ccc']->contentsCount(),
        );

        $this->assertEquals(
            2,
            $this->orgPlus->organisationUnits['Ddd']->contentsCount(),
        );

        $this->assertEquals(
            1,
            $this->orgPlus->organisationUnits['Eee']->contentsCount(),
        );
    }
}
