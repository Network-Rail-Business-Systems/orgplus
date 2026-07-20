<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\Person;

use NetworkRailBusinessSystems\OrgPlus\OrganisationUnit;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\Person;

class AddPersonTest extends TestCase
{
    protected Person $person;

    protected OrganisationUnit $organisationUnit;

    protected function setUp(): void
    {
        parent::setUp();

        $this->organisationUnit = new OrganisationUnit();
        $this->organisationUnit->name = 'Aaa';

        $this->person = new Person();
        $this->person->addOrganisationUnit($this->organisationUnit);
    }

    public function test(): void
    {
        $this->assertEquals(
            'Aaa',
            $this->person->organisationUnit->name,
        );
    }
}
