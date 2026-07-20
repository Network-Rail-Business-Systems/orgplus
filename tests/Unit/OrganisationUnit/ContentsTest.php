<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrganisationUnit;

use NetworkRailBusinessSystems\OrgPlus\OrganisationUnit;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class ContentsTest extends TestCase
{
    protected OrganisationUnit $organisationUnit;

    protected function setUp(): void
    {
        parent::setUp();

        $this->organisationUnit = new OrganisationUnit();
    }

    public function test(): void
    {
        $this->assertEquals(
            $this->organisationUnit->upns,
            $this->organisationUnit->contents(),
        );
    }
}
