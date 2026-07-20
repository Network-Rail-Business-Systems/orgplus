<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\Import;

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
        $this->assertCount(1, $costCentre->organisationUnits);
        $this->assertCount(2, $costCentre->upns);
        $this->assertCount(3, $costCentre->people);

        // Organisation Units
        $this->assertCount(1, $this->orgPlus->organisationUnits);

        $organisationUnit = $this->orgPlus->organisationUnits['Organisation'];
        $this->assertEquals('12345', $organisationUnit->costCentre->number);
        $this->assertCount(2, $organisationUnit->upns);
        $this->assertCount(2, $organisationUnit->people);

        // Upns
        $this->assertCount(2, $this->orgPlus->upns);

        $upn = $this->orgPlus->upns['A234'];
        $this->assertEquals(12345, $upn->costCentre->number);
        $this->assertEquals('Organisation', $upn->organisationUnit->name);
        $this->assertCount(2, $upn->people);

        // People
        $this->assertCount(3, $this->orgPlus->people);

        $person = $this->orgPlus->people['a@b.com'];
        $this->assertEquals(12345, $person->costCentre->number);
        $this->assertEquals('Organisation', $person->organisationUnit->name);
        $this->assertEquals('A123', $person->upn->code);
    }
}
