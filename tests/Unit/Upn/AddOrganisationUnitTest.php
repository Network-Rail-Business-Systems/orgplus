<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\Upn;

use NetworkRailBusinessSystems\OrgPlus\OrganisationUnit;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\Upn;

class AddOrganisationUnitTest extends TestCase
{
    protected Upn $upn;

    protected OrganisationUnit $organisationUnit;

    protected function setUp(): void
    {
        parent::setUp();

        $this->organisationUnit = new OrganisationUnit();
        $this->organisationUnit->name = 'Aaa';

        $this->upn = new Upn();
        $this->upn->addOrganisationUnit($this->organisationUnit);
    }

    public function test(): void
    {
        $this->assertEquals(
            'Aaa',
            $this->upn->organisationUnit->name,
        );
    }
}
