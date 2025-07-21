<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\Hierarchy;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class GetRootsTest extends TestCase
{
    protected array $roots;

    protected OrgPlus $orgPlus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orgPlus = OrgPlus::import(
            base_path('/tests/Data/hierarchy.csv'),
        );

        $this->roots = $this->orgPlus->getRoots($this->orgPlus->upns);
    }

    public function test(): void
    {
        $this->assertArrayHasKey('A123', $this->roots);
        $this->assertArrayNotHasKey('A234', $this->roots);
    }
}
