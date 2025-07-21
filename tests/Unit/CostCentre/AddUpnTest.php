<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\CostCentre;

use NetworkRailBusinessSystems\OrgPlus\Upn;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\CostCentre;

class AddUpnTest extends TestCase
{
    protected CostCentre $costCentre;

    protected Upn $upn;

    protected function setUp(): void
    {
        parent::setUp();

        $this->upn = new Upn();
        $this->upn->code = 'A123';

        $this->costCentre = new CostCentre();
        $this->costCentre->addUpn($this->upn);
    }

    public function test(): void
    {
        $this->assertEquals(
            'A123',
            $this->costCentre->upns['A123']->code,
        );
    }
}
