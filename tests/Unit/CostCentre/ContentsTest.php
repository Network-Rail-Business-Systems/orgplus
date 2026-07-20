<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\CostCentre;

use NetworkRailBusinessSystems\OrgPlus\CostCentre;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class ContentsTest extends TestCase
{
    protected CostCentre $costCentre;

    protected function setUp(): void
    {
        parent::setUp();

        $this->costCentre = new CostCentre();
    }

    public function test(): void
    {
        $this->assertEquals(
            $this->costCentre->organisationUnits,
            $this->costCentre->contents(),
        );
    }
}
