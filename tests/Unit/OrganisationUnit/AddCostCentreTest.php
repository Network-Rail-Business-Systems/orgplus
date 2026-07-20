<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrganisationUnit;

use NetworkRailBusinessSystems\OrgPlus\CostCentre;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\OrganisationUnit;

class AddCostCentreTest extends TestCase
{
    protected OrganisationUnit $organisationUnit;

    protected CostCentre $costCentre;

    protected function setUp(): void
    {
        parent::setUp();

        $this->costCentre = new CostCentre();
        $this->costCentre->number = 12345;

        $this->organisationUnit = new OrganisationUnit();
        $this->organisationUnit->addCostCentre($this->costCentre);
    }

    public function test(): void
    {
        $this->assertEquals(
            12345,
            $this->organisationUnit->costCentre->number,
        );
    }
}
