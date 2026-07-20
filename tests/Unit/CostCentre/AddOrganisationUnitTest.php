<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\CostCentre;

use NetworkRailBusinessSystems\OrgPlus\OrganisationUnit;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\CostCentre;

class AddOrganisationUnitTest extends TestCase
{
    protected CostCentre $costCentre;

    protected OrganisationUnit $organisationUnit;

    protected function setUp(): void
    {
        parent::setUp();

        $this->organisationUnit = new OrganisationUnit();
        $this->organisationUnit->name = 'Aaa';

        $this->costCentre = new CostCentre();
        $this->costCentre->addOrganisationUnit($this->organisationUnit);
    }

    public function test(): void
    {
        $this->assertEquals(
            'Aaa',
            $this->costCentre->organisationUnits['Aaa']->name,
        );
    }
}
