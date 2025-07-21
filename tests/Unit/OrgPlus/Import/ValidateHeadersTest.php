<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\Import;

use NetworkRailBusinessSystems\OrgPlus\MissingHeadersException;
use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use Spatie\SimpleExcel\SimpleExcelReader;

class ValidateHeadersTest extends TestCase
{
    protected OrgPlus $orgPlus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orgPlus = new OrgPlus();

        config()->set('orgplus', require base_path('/src/config.php'));
    }

    public function testAllowsWithGoodHeaders(): void
    {
        $this->expectNotToPerformAssertions();

        $this->check('blank');
    }

    public function testThrowsExceptionWhenMissingRequired(): void
    {
        $this->expectException(MissingHeadersException::class);
        $this->expectExceptionMessage(
            'The following headers are missing from the CSV: ' . implode(', ', config('orgplus.required_headers')),
        );

        $this->check('bad_headers');
    }

    protected function check(string $file): void
    {
        $csv = SimpleExcelReader::create(
            base_path("/tests/Data/$file.csv"),
        );

        $this->orgPlus->validateHeaders($csv);
    }
}
