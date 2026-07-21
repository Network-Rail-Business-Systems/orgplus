<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlusModel;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class ContentsDescendantsCountTest extends TestCase
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
            8,
            $this->orgPlus->organisationUnits['Aaa']->contentsDescendantsCount(),
        );

        $this->assertEquals(
            3,
            $this->orgPlus->organisationUnits['Bbb']->contentsDescendantsCount(),
        );

        $this->assertEquals(
            1,
            $this->orgPlus->organisationUnits['Ccc']->contentsDescendantsCount(),
        );

        $this->assertEquals(
            3,
            $this->orgPlus->organisationUnits['Ddd']->contentsDescendantsCount(),
        );

        $this->assertEquals(
            1,
            $this->orgPlus->organisationUnits['Eee']->contentsDescendantsCount(),
        );
    }
}
