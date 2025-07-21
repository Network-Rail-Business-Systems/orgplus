<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\Person;

use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\Person;
use NetworkRailBusinessSystems\OrgPlus\Upn;

class MatchWithParentTest extends TestCase
{
    protected Person $parent;

    protected Upn $parentUpn;

    protected Person $person;

    protected Upn $personUpn;

    protected function setUp(): void
    {
        parent::setUp();

        $this->parentUpn = new Upn();
        $this->parentUpn->code = 'A123';

        $this->personUpn = new Upn();
        $this->personUpn->code = 'A234';
        $this->personUpn->addParent($this->parentUpn);

        $this->person = new Person();
        $this->person->email = 'person';
        $this->person->addUpn($this->personUpn);

        $this->parent = new Person();
        $this->parent->email = 'parent';
        $this->parent->addUpn($this->parentUpn);

        $this->parentUpn->addPerson($this->parent);

        $this->person->matchWithParent();
    }

    public function test(): void
    {
        $this->assertEquals(
            'parent',
            $this->person->parents['parent']->email,
        );

        $this->assertEquals(
            'person',
            $this->parent->children['person']->email,
        );
    }
}
