<?php

namespace NetworkRailBusinessSystems\OrgPlus;

use Spatie\SimpleExcel\SimpleExcelReader;

/**
 * @property array<string, CostCentre> $costCentres
 * @property array<string, Person> $people
 * @property array<string, Upn> $upns
 */
class OrgPlus
{
    public array $costCentres = [];

    public array $people = [];

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
            throw new MissingHeadersException(
                'The following headers are missing from the CSV: ' . implode(', ', $missingHeaders),
            );
        }
    }

    public function gatherRows(SimpleExcelReader $csv): void
    {
        $csv->getRows()->each(function (array $row) {
            $costCentre = $this->gatherModel(CostCentre::class, 'costCentres', $row);
            $person = $this->gatherModel(Person::class, 'people', $row);
            $upn = $this->gatherModel(Upn::class, 'upns', $row);

            if ($costCentre !== null) {
                $costCentre->addRelation($person, 'people');
                $costCentre->addRelation($upn, 'upns');
            }

            if ($person !== null) {
                $person->addRelation($costCentre, 'costCentre');
                $person->addRelation($upn, 'upn');
            }

            if ($upn !== null) {
                $upn->addRelation($costCentre, 'costCentre');
                $upn->addRelation($person, 'people');
            }
        });
    }

    /** @param class-string<OrgPlusModel> $model */
    public function gatherModel(
        string $model,
        string $library,
        array $row,
    ): ?OrgPlusModel {
        if (array_key_exists($model::REQUIRED_KEY, $row) === false) {
            return null;
        }

        $key = $row[$model::REQUIRED_KEY];

        if (empty($key) === true) {
            return null;
        }

        if (array_key_exists($key, $this->$library) === false) {
            $this->$library[$key] = $model::make($row);
        }

        return $this->$library[$key];
    }

    public function matchRows(): void
    {
        // TODO Nesting and hierarchy, when relevant fields present
    }
}
