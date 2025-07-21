<?php

namespace NetworkRailBusinessSystems\OrgPlus;

use Spatie\SimpleExcel\SimpleExcelReader;

/**
 * @property array<int, CostCentre> $costCentres
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

        $orgPlus->generateHierarchy();

        return $orgPlus;
    }

    public function validateHeaders(SimpleExcelReader $csv): void
    {
        $headers = $csv->getHeaders();
        $expectedHeaders = config('orgplus.required_headers', []);
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
            /** @var ?CostCentre $costCentre */
            $costCentre = $this->gatherModel(CostCentre::class, 'costCentres', $row);

            /** @var ?Person $person */
            $person = $this->gatherModel(Person::class, 'people', $row);

            /** @var ?Upn $upn */
            $upn = $this->gatherModel(Upn::class, 'upns', $row);

            if ($costCentre !== null) {
                $costCentre->addPerson($person);
                $costCentre->addUpn($upn);
            }

            if ($person !== null) {
                $person->addCostCentre($costCentre);
                $person->addUpn($upn);
            }

            if ($upn !== null) {
                $upn->addCostCentre($costCentre);
                $upn->addPerson($person);
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

    // Hierarchy
    public function generateHierarchy(): void
    {
        if (empty($this->upns) === true) {
            return;
        }

        $this->pairModels($this->upns, $this->upns);
        $this->pairModels($this->costCentres);
        $this->pairModels($this->people);
    }

    public function pairModels(array $library, array $support = []): void
    {
        if (empty($library) === true) {
            return;
        }

        foreach ($library as $model) {
            $model->matchWithParent($support);
        }
    }
}
