<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\CostCentre;

use NetworkRailBusinessSystems\OrgPlus\Person;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\CostCentre;

class AddPersonTest extends TestCase
{
    protected CostCentre $costCentre;

    protected Person $person;

    protected function setUp(): void
    {
        parent::setUp();

        $this->person = new Person();
        $this->person->email = 'a@b.com';

        $this->costCentre = new CostCentre();
        $this->costCentre->addPerson($this->person);
    }

    public function test(): void
    {
        $this->assertEquals(
            'a@b.com',
            $this->costCentre->people['a@b.com']->email,
        );
    }
}
