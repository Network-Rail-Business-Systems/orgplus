<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrganisationUnit;

use NetworkRailBusinessSystems\OrgPlus\Upn;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\OrganisationUnit;

class AddUpnTest extends TestCase
{
    protected OrganisationUnit $organisationUnit;

    protected Upn $upn;

    protected function setUp(): void
    {
        parent::setUp();

        $this->upn = new Upn();
        $this->upn->code = 'A123';

        $this->organisationUnit = new OrganisationUnit();
        $this->organisationUnit->addUpn($this->upn);
    }

    public function test(): void
    {
        $this->assertEquals(
            'A123',
            $this->organisationUnit->upns['A123']->code,
        );
    }
}
