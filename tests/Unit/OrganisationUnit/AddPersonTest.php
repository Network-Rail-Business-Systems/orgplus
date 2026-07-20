<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrganisationUnit;

use NetworkRailBusinessSystems\OrgPlus\Person;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\OrganisationUnit;

class AddPersonTest extends TestCase
{
    protected OrganisationUnit $organisationUnit;

    protected Person $person;

    protected function setUp(): void
    {
        parent::setUp();

        $this->person = new Person();
        $this->person->email = 'a@b.com';

        $this->organisationUnit = new OrganisationUnit();
        $this->organisationUnit->addPerson($this->person);
    }

    public function test(): void
    {
        $this->assertEquals(
            'a@b.com',
            $this->organisationUnit->people['a@b.com']->email,
        );
    }
}
