<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\Import;

use Illuminate\Http\UploadedFile;
use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class ImportTest extends TestCase
{
    protected OrgPlus $orgPlus;

    public function testPath(): void
    {
        $this->orgPlus = OrgPlus::import(
            base_path('/tests/Data/related.csv'),
        );

        $this->assertCount(1, $this->orgPlus->costCentres);
        $this->assertCount(3, $this->orgPlus->people);
        $this->assertCount(2, $this->orgPlus->upns);
    }

    public function testFile(): void
    {
        $this->orgPlus = OrgPlus::import(
            new UploadedFile(
                base_path('/tests/Data/related.csv'),
                'related.csv',
            ),
        );

        $this->assertCount(1, $this->orgPlus->costCentres);
        $this->assertCount(3, $this->orgPlus->people);
        $this->assertCount(2, $this->orgPlus->upns);
    }
}
