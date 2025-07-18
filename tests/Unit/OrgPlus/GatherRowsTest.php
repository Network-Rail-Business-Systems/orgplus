<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use Spatie\SimpleExcel\SimpleExcelReader;

class GatherRowsTest extends TestCase
{
    protected OrgPlus $orgPlus;

    protected function setUp(): void
    {
        parent::setUp();

        $csv = SimpleExcelReader::create(
            base_path('/tests/Data/related.csv'),
        );

        $this->orgPlus = new OrgPlus();
        $this->orgPlus->gatherRows($csv);
    }

    public function test(): void
    {
        // Cost Centres
        $this->assertCount(1, $this->orgPlus->costCentres);

        $costCentre = $this->orgPlus->costCentres[12345];
        $this->assertCount(3, $costCentre->people);
        $this->assertCount(2, $costCentre->upns);

        // People
        $this->assertCount(3, $this->orgPlus->people);

        $person = $this->orgPlus->people['a@b.com'];
        $this->assertEquals(12345, $person->costCentre->code);
        $this->assertEquals('A123', $person->upn->code);

        // Upns
        $this->assertCount(2, $this->orgPlus->upns);

        $upn = $this->orgPlus->upns['A234'];
        $this->assertEquals(12345, $upn->costCentre->code);
        $this->assertCount(2, $upn->people);
    }
}
