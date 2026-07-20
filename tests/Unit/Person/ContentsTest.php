<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\Person;

use NetworkRailBusinessSystems\OrgPlus\Person;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class ContentsTest extends TestCase
{
    protected Person $person;

    protected function setUp(): void
    {
        parent::setUp();

        $this->person = new Person();
    }

    public function test(): void
    {
        $this->assertEquals(
            [],
            $this->person->contents(),
        );
    }
}
