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
        dd($this->orgPlus);
    }
}
