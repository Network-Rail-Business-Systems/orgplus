<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\Person;

use NetworkRailBusinessSystems\OrgPlus\CostCentre;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\Person;

class AddCostCentreTest extends TestCase
{
    protected Person $person;

    protected CostCentre $costCentre;

    protected function setUp(): void
    {
        parent::setUp();

        $this->costCentre = new CostCentre();
        $this->costCentre->code = 12345;

        $this->person = new Person();
        $this->person->addCostCentre($this->costCentre);
    }

    public function test(): void
    {
        $this->assertEquals(
            12345,
            $this->person->costCentre->code,
        );
    }
}
