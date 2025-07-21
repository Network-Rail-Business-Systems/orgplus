<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\Upn;

use NetworkRailBusinessSystems\OrgPlus\CostCentre;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\Upn;

class AddCostCentreTest extends TestCase
{
    protected Upn $upn;

    protected CostCentre $costCentre;

    protected function setUp(): void
    {
        parent::setUp();

        $this->costCentre = new CostCentre();
        $this->costCentre->code = 12345;

        $this->upn = new Upn();
        $this->upn->addCostCentre($this->costCentre);
    }

    public function test(): void
    {
        $this->assertEquals(
            12345,
            $this->upn->costCentre->code,
        );
    }
}
