<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrganisationUnit;

use NetworkRailBusinessSystems\OrgPlus\OrganisationUnit;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\Upn;

class MatchWithParentTest extends TestCase
{
    protected OrganisationUnit $parent;

    protected OrganisationUnit $organisationUnit;

    protected Upn $parentUpn;

    protected Upn $organisationUnitUpn;

    protected function setUp(): void
    {
        parent::setUp();

        $this->parentUpn = new Upn();
        $this->parentUpn->code = 'A123';

        $this->organisationUnitUpn = new Upn();
        $this->organisationUnitUpn->code = 'A234';
        $this->organisationUnitUpn->addParent($this->parentUpn);

        $this->organisationUnit = new OrganisationUnit();
        $this->organisationUnit->name = 'Bbb';
        $this->organisationUnit->addUpn($this->organisationUnitUpn);

        $this->parent = new OrganisationUnit();
        $this->parent->name = 'Aaa';
        $this->parent->addUpn($this->parentUpn);

        $this->parentUpn->addOrganisationUnit($this->parent);
        $this->organisationUnitUpn->addOrganisationUnit($this->organisationUnit);

        $this->library = [
            'Aaa' => $this->parent,
            'Bbb' => $this->organisationUnit,
        ];
    }

    public function test(): void
    {
        $this->organisationUnit->matchWithParent();

        $this->assertEquals(
            'Aaa',
            $this->organisationUnit->parents['Aaa']->name,
        );

        $this->assertEquals(
            'Bbb',
            $this->parent->children['Bbb']->name,
        );
    }

    public function testSkipsWhenNoUpn(): void
    {
        $this->organisationUnit->upns = [];
        $this->organisationUnit->matchWithParent();

        $this->assertArrayNotHasKey('Aaa', $this->organisationUnit->parents);
        $this->assertArrayNotHasKey('Bbb', $this->parent->children);
    }

    public function testSkipsWhenNoParent(): void
    {
        $this->parentUpn->organisationUnit = null;
        $this->organisationUnit->matchWithParent();

        $this->assertArrayNotHasKey('Aaa', $this->organisationUnit->parents);
        $this->assertArrayNotHasKey('Bbb', $this->parent->children);
    }
}
