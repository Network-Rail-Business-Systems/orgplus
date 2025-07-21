<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\CostCentre;

use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\CostCentre;
use NetworkRailBusinessSystems\OrgPlus\Upn;

class MatchWithParentTest extends TestCase
{
    protected CostCentre $parent;

    protected Upn $parentUpn;

    protected CostCentre $costCentre;

    protected Upn $costCentreUpn;

    protected Upn $blankUpn;

    protected function setUp(): void
    {
        parent::setUp();

        $this->blankUpn = new Upn();
        $this->blankUpn->code = 'A234';

        $this->parentUpn = new Upn();
        $this->parentUpn->code = 'A123';

        $this->costCentreUpn = new Upn();
        $this->costCentreUpn->code = 'A345';
        $this->costCentreUpn->addParent($this->parentUpn);
        $this->costCentreUpn->addParent($this->blankUpn);

        $this->costCentre = new CostCentre();
        $this->costCentre->code = 23456;
        $this->costCentre->addUpn($this->costCentreUpn);
        $this->costCentre->addUpn($this->blankUpn);

        $this->parent = new CostCentre();
        $this->parent->code = 12345;
        $this->parent->addUpn($this->parentUpn);

        $this->parentUpn->addCostCentre($this->parent);

        $this->costCentre->matchWithParent();
    }

    public function test(): void
    {
        $this->assertEquals(
            12345,
            $this->costCentre->parents[12345]->code,
        );

        $this->assertEquals(
            23456,
            $this->parent->children[23456]->code,
        );
    }
}
