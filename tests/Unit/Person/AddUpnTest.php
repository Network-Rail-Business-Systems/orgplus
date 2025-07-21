<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\Person;

use NetworkRailBusinessSystems\OrgPlus\Upn;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\Person;

class AddUpnTest extends TestCase
{
    protected Person $person;

    protected Upn $upn;

    protected function setUp(): void
    {
        parent::setUp();

        $this->upn = new Upn();
        $this->upn->code = 'A123';

        $this->person = new Person();
        $this->person->addUpn($this->upn);
    }

    public function test(): void
    {
        $this->assertEquals(
            'A123',
            $this->person->upn->code,
        );
    }
}
