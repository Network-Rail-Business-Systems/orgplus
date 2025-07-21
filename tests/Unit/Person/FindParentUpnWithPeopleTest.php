<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\Person;

use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\Person;
use NetworkRailBusinessSystems\OrgPlus\Upn;

class FindParentUpnWithPeopleTest extends TestCase
{
    protected Person $parent;

    protected Upn $parentUpn;

    protected Upn $middleUpn;

    protected Person $person;

    protected Upn $personUpn;

    protected function setUp(): void
    {
        parent::setUp();

        $this->parentUpn = new Upn();
        $this->parentUpn->code = 'A123';

        $this->middleUpn = new Upn();
        $this->middleUpn->addParent($this->parentUpn);

        $this->personUpn = new Upn();
        $this->personUpn->code = 'A234';
        $this->personUpn->addParent($this->middleUpn);

        $this->person = new Person();
        $this->person->email = 'person';
        $this->person->addUpn($this->personUpn);

        $this->parent = new Person();
        $this->parent->email = 'parent';
        $this->parent->addUpn($this->parentUpn);

        $this->parentUpn->addPerson($this->parent);
    }

    public function test(): void
    {
        $this->person->matchWithParent();

        $this->assertEquals(
            $this->parentUpn->code,
            $this->person->findParentUpnWithPeople($this->personUpn)->code,
        );
    }

    public function testNullWhenNoParents(): void
    {
        $this->middleUpn->parents = [];

        $this->person->matchWithParent();

        $this->assertNull(
            $this->person->findParentUpnWithPeople($this->personUpn),
        );
    }
}
