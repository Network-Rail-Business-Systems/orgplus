<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class GenerateHierarchyTest extends TestCase
{
    protected OrgPlus $orgPlus;

    public function test(): void
    {
        $this->orgPlus = OrgPlus::import(
            base_path('/tests/Data/hierarchy.csv'),
        );

        // Upns
        $this->assertEmpty($this->orgPlus->upns['A123']->parents);
        $this->assertArrayHasKey('A234', $this->orgPlus->upns['A123']->children);

        $this->assertArrayHasKey('A123', $this->orgPlus->upns['A234']->parents);
        $this->assertArrayHasKey('A345', $this->orgPlus->upns['A234']->children);
        $this->assertArrayHasKey('A678', $this->orgPlus->upns['A234']->children);

        $this->assertArrayHasKey('A234', $this->orgPlus->upns['A345']->parents);
        $this->assertArrayHasKey('A456', $this->orgPlus->upns['A345']->children);

        $this->assertArrayHasKey('A345', $this->orgPlus->upns['A456']->parents);
        $this->assertArrayHasKey('A567', $this->orgPlus->upns['A456']->children);

        $this->assertArrayHasKey('A456', $this->orgPlus->upns['A567']->parents);
        $this->assertEmpty($this->orgPlus->upns['A567']->children);

        $this->assertArrayHasKey('A234', $this->orgPlus->upns['A678']->parents);
        $this->assertArrayHasKey('A789', $this->orgPlus->upns['A678']->children);

        $this->assertArrayHasKey('A678', $this->orgPlus->upns['A789']->parents);
        $this->assertArrayHasKey('A890', $this->orgPlus->upns['A789']->children);

        $this->assertArrayHasKey('A789', $this->orgPlus->upns['A890']->parents);
        $this->assertEmpty($this->orgPlus->upns['A890']->children);

        // Cost Centres
        $this->assertEmpty($this->orgPlus->costCentres[12345]->parents);
        $this->assertArrayHasKey(23456, $this->orgPlus->costCentres[12345]->children);
        $this->assertArrayHasKey(34567, $this->orgPlus->costCentres[12345]->children);

        $this->assertArrayHasKey(12345, $this->orgPlus->costCentres[23456]->parents);
        $this->assertArrayHasKey(45678, $this->orgPlus->costCentres[23456]->children);

        $this->assertArrayHasKey(12345, $this->orgPlus->costCentres[34567]->parents);
        $this->assertArrayHasKey(56789, $this->orgPlus->costCentres[34567]->children);

        $this->assertArrayHasKey(23456, $this->orgPlus->costCentres[45678]->parents);

        $this->assertArrayHasKey(34567, $this->orgPlus->costCentres[56789]->parents);

        // People
        $this->assertEmpty($this->orgPlus->people['a@b.com']->parents);
        $this->assertArrayHasKey('b@c.com', $this->orgPlus->people['a@b.com']->children);
        $this->assertArrayHasKey('c@d.com', $this->orgPlus->people['a@b.com']->children);

        $this->assertArrayHasKey('a@b.com', $this->orgPlus->people['b@c.com']->parents);
        $this->assertArrayHasKey('d@e.com', $this->orgPlus->people['b@c.com']->children);
        $this->assertArrayHasKey('g@h.com', $this->orgPlus->people['b@c.com']->children);

        $this->assertArrayHasKey('a@b.com', $this->orgPlus->people['c@d.com']->parents);
        $this->assertArrayHasKey('d@e.com', $this->orgPlus->people['c@d.com']->children);
        $this->assertArrayHasKey('g@h.com', $this->orgPlus->people['c@d.com']->children);

        $this->assertArrayHasKey('b@c.com', $this->orgPlus->people['d@e.com']->parents);
        $this->assertArrayHasKey('c@d.com', $this->orgPlus->people['d@e.com']->parents);
        $this->assertArrayHasKey('e@f.com', $this->orgPlus->people['d@e.com']->children);

        $this->assertArrayHasKey('d@e.com', $this->orgPlus->people['e@f.com']->parents);
        $this->assertArrayHasKey('f@g.com', $this->orgPlus->people['e@f.com']->children);

        $this->assertArrayHasKey('e@f.com', $this->orgPlus->people['f@g.com']->parents);
        $this->assertEmpty($this->orgPlus->people['f@g.com']->children);

        $this->assertArrayHasKey('b@c.com', $this->orgPlus->people['g@h.com']->parents);
        $this->assertArrayHasKey('c@d.com', $this->orgPlus->people['g@h.com']->parents);
        $this->assertArrayHasKey('h@i.com', $this->orgPlus->people['g@h.com']->children);

        $this->assertArrayHasKey('g@h.com', $this->orgPlus->people['h@i.com']->parents);
        $this->assertArrayHasKey('i@j.com', $this->orgPlus->people['h@i.com']->children);

        $this->assertArrayHasKey('h@i.com', $this->orgPlus->people['i@j.com']->parents);
        $this->assertEmpty($this->orgPlus->people['i@j.com']->children);
    }

    public function testHandlesNoUpns(): void
    {
        $this->orgPlus = OrgPlus::import(
            base_path('/tests/Data/no_upns.csv'),
        );

        $this->assertEmpty($this->orgPlus->costCentres[12345]->children);
    }
}
