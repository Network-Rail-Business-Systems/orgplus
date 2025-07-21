<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\Upn;

use NetworkRailBusinessSystems\OrgPlus\Person;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\Upn;

class AddPersonTest extends TestCase
{
    protected Upn $upn;

    protected Person $person;

    protected function setUp(): void
    {
        parent::setUp();

        $this->person = new Person();
        $this->person->email = 'a@b.com';

        $this->upn = new Upn();
        $this->upn->addPerson($this->person);
    }

    public function test(): void
    {
        $this->assertEquals(
            'a@b.com',
            $this->upn->people['a@b.com']->email,
        );
    }
}
