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

        $orgPlus->linkLibraries();
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

    // Relationships
    public function linkLibraries(): void
    {
        $this->linkModels($this->costCentres);
        $this->linkModels($this->people);
        $this->linkModels($this->upns);
    }

    public function linkModels(array $library): void
    {
        foreach ($library as $model) {
            $model->matchWithRelated($this->costCentres, $this->people, $this->upns);
        }
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

    /**
     * @param OrgPlusModel[] $library
     * @return OrgPlusModel[]
     */
    public function getRoots(array $library): array
    {
        $roots = [];

        foreach ($library as $model) {
            if (empty($model->parents) === true) {
                $key = $model::KEY_FIELD;
                $roots[$model->$key] = $model;
            }
        }

        return $roots;
    }

    // Linked Lists
    public function makeHierarchy(array $library): array
    {
        $map = [];
        $visited = [];
        $roots = $this->getRoots($library);

        foreach ($roots as $model) {
            $model->mapChildren($map, $visited);
        }

        return $map;
    }

    public function makeList(array $library, string $key, string $relationship, string $valueKey): array
    {
        $hasNestedRelationship = false;
        $list = [];
        $steps = [];

        if (str_contains($relationship, '.') === true) {
            $hasNestedRelationship = true;
            $steps = explode('.', $relationship);
        }

        foreach ($library as $model) {
            if ($hasNestedRelationship === false) {
                $related = $model->$relationship;
            } else {
                $related = $model;

                foreach ($steps as $step) {
                    $related = $related->$step;

                    // TODO Handle array at step - Defer to object to get values from relationship passing back
                }
            }

            $list[$model->$key] = is_array($related) === true
                ? array_column($related, $valueKey)
                : $related->$valueKey;
        }

        return $list;
    }

    // --- Cost Centres
    /** @returns array<int, int[]> Cost Centre => [Child Cost Centres] */
    public function costCentreChildren(): array
    {
        return $this->makeList($this->costCentres, CostCentre::KEY_FIELD, 'children', CostCentre::KEY_FIELD);
    }

    public function costCentreHierarchy(): array
    {
        return $this->makeHierarchy($this->costCentres);
    }

    /** @returns array<int, int[]> Cost Centre => [Parent Cost Centres] */
    public function costCentreParents(): array
    {
        return $this->makeList($this->costCentres, CostCentre::KEY_FIELD, 'parents', CostCentre::KEY_FIELD);
    }

    /** @returns array<int, string[]> Cost Centre => [E-mails] */
    public function costCentrePeople(): array
    {
        return $this->makeList($this->costCentres, CostCentre::KEY_FIELD, 'people', Person::KEY_FIELD);
    }

    /** @returns array<int, string[]> Cost Centre => [Upns] */
    public function costCentreUpns(): array
    {
        return $this->makeList($this->costCentres, CostCentre::KEY_FIELD, 'upns', Upn::KEY_FIELD);
    }

    // --- People
    /** @returns array<string, string[]> E-mail => [Child E-mails] */
    public function personChildren(): array
    {
        return $this->makeList($this->people, Person::KEY_FIELD, 'children', Person::KEY_FIELD);
    }

    /** @returns array<string, ?int> E-mail => Cost Centre */
    public function personCostCentres(): array
    {
        return $this->makeList($this->people, Person::KEY_FIELD, 'costCentre', CostCentre::KEY_FIELD);
    }

    public function personHierarchy(): array
    {
        return $this->makeHierarchy($this->people);
    }

    /** @returns array<string, ?string> E-mail => HR Manager E-mail */
    public function personHrManagers(): array
    {
        return $this->makeList($this->people, Person::KEY_FIELD, 'upn.hrManager', Person::KEY_FIELD);
    }

    /** @returns array<string, string[]> E-mail => [Parent E-mails] */
    public function personParents(): array
    {
        return $this->makeList($this->people, Person::KEY_FIELD, 'parents', Person::KEY_FIELD);
    }

    /** @returns array<string, ?string> E-mail => Upn */
    public function personUpns(): array
    {
        return $this->makeList($this->people, Person::KEY_FIELD, 'upn', Upn::KEY_FIELD);
    }

    // --- Upns
    /** @returns array<string, string[]> Upn => [Child Upns] */
    public function upnChildren(): array
    {
        return $this->makeList($this->upns, Upn::KEY_FIELD, 'children', Upn::KEY_FIELD);
    }

    /** @returns array<string, ?int> Upn => Cost Centre */
    public function upnCostCentre(): array
    {
        return $this->makeList($this->upns, Upn::KEY_FIELD, 'costCentre', CostCentre::KEY_FIELD);
    }

    public function upnHierarchy(): array
    {
        return $this->makeHierarchy($this->upns);
    }

    /** @returns array<string, string> Upn => HR Manager Upn */
    public function upnHrManagers(): array
    {
        return $this->makeList($this->upns, Upn::KEY_FIELD, 'hrManager', Upn::KEY_FIELD);
    }

    /** @returns array<string, ?string> Upn => [Parent Upns] */
    public function upnParents(): array
    {
        return $this->makeList($this->upns, Upn::KEY_FIELD, 'parents', Upn::KEY_FIELD);
    }

    /** @returns array<string, string[]> Upn => [E-mails] */
    public function upnPeople(): array
    {
        return $this->makeList($this->upns, Upn::KEY_FIELD, 'people', Person::KEY_FIELD);
    }
}
