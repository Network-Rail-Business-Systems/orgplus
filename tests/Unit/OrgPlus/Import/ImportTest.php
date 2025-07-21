<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\Import;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class ImportTest extends TestCase
{
    protected OrgPlus $orgPlus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orgPlus = OrgPlus::import(
            base_path('/tests/Data/related.csv'),
        );
    }

    public function test(): void
    {
        $this->assertCount(1, $this->orgPlus->costCentres);
        $this->assertCount(3, $this->orgPlus->people);
        $this->assertCount(2, $this->orgPlus->upns);
    }
}
