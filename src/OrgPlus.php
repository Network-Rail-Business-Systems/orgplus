<?php

namespace NetworkRailBusinessSystems\OrgPlus;

use Spatie\SimpleExcel\SimpleExcelReader;

class OrgPlus
{
    public array $upns = [];

    // Import
    public static function import(string $path): self
    {
        $csv = SimpleExcelReader::create($path);

        $orgPlus = new self();
        $orgPlus->validateHeaders($csv);
        $orgPlus->gatherRows($csv);

        $csv->close();

        $orgPlus->matchRows();

        return $orgPlus;
    }

    public function validateHeaders(SimpleExcelReader $csv): void
    {
        $headers = $csv->getHeaders();
        $expectedHeaders = config('orgplus.required_headers', ['UPN']);
        $missingHeaders = [];

        foreach ($expectedHeaders as $expected) {
            if (in_array($expected, $headers) === false) {
                $missingHeaders[] = $expected;
            }
        }

        if (empty($missingHeaders) === false) {
            throw new MissingHeaderException(
                'The following headers are missing from the CSV: ' . implode(', ', $missingHeaders),
            );
        }
    }

    public function gatherRows(SimpleExcelReader $csv): void
    {
        $csv->getRows()->each(function (array $row) {
            $this->upns[$row['UPN']] = Upn::make($row);
        });
    }

    public function matchRows(): void
    {
        // TODO Nesting and hierarchy, when relevant fields present
    }
}
