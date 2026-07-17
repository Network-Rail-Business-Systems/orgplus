<?php

namespace NetworkRailBusinessSystems\OrgPlus;

use Illuminate\Http\UploadedFile;
use Spatie\SimpleExcel\SimpleExcelReader;

/**
 * @property array<int, CostCentre> $costCentres
 * @property array<string, OrganisationUnit> $organisationUnits
 * @property array<string, Person> $people
 * @property array<string, Upn> $upns
 */
class OrgPlus
{
    public array $costCentres = [];

    public array $organisationUnits = [];

    public array $people = [];

    public array $upns = [];

    // Import
    public static function import(UploadedFile|string $file, ?string $type = null): self
    {
        if ($file instanceof UploadedFile === true) {
            $path = $file->path();
            $type = $type ?? $file->extension();
        } else {
            $path = $file;
            $type = $type ?? 'csv';
        }

        $csv = SimpleExcelReader::create($path, $type);

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

            /** @var ?OrganisationUnit $organisationUnit */
            $organisationUnit = $this->gatherModel(OrganisationUnit::class, 'organisationUnits', $row);

            /** @var ?Upn $upn */
            $upn = $this->gatherModel(Upn::class, 'upns', $row);

            /** @var ?Person $person */
            $person = $this->gatherModel(Person::class, 'people', $row);

            if ($costCentre !== null) {
                $costCentre->addOrganisationUnit($organisationUnit);
                $costCentre->addPerson($person);
                $costCentre->addUpn($upn);
            }

            if ($organisationUnit !== null) {
                $organisationUnit->addCostCentre($costCentre);
                $organisationUnit->addPerson($person);
                $organisationUnit->addUpn($upn);
            }

            if ($person !== null) {
                $person->addCostCentre($costCentre);
                $person->addOrganisationUnit($organisationUnit);
                $person->addUpn($upn);
            }

            if ($upn !== null) {
                $upn->addCostCentre($costCentre);
                $upn->addOrganisationUnit($organisationUnit);
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
        $this->pairModels($this->organisationUnits);
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
        $list = [];

        foreach ($library as $model) {
            $list[$model->$key] = is_array($model->$relationship) === true
                ? array_column($model->$relationship, $valueKey)
                : $model->$relationship?->$valueKey;
        }

        return $list;
    }

    // --- Cost Centres
    /** @returns array<int, int[]> Cost Centre => [Child Cost Centres] */
    public function costCentreChildren(): array
    {
        return $this->makeList($this->costCentres, CostCentre::KEY_FIELD, 'children', CostCentre::KEY_FIELD);
    }

    /** @returns array<int, int[]> Cost Centre => [Child Cost Centres], deeply nested */
    public function costCentreHierarchy(): array
    {
        return $this->makeHierarchy($this->costCentres);
    }

    /** @returns array<int, string[]> Cost Centre => [Organisation Units] */
    public function costCentreOrganisationUnits(): array
    {
        return $this->makeList($this->costCentres, CostCentre::KEY_FIELD, 'organisationUnits', OrganisationUnit::KEY_FIELD);
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

    // --- Organisation Units
    /** @return array<string, string[]> Organisation Unit => [Child Organisation Units] */
    public function organisationUnitChildren(): array
    {
        return $this->makeList($this->organisationUnits, OrganisationUnit::KEY_FIELD, 'children', OrganisationUnit::KEY_FIELD);
    }

    /** @return array<string, ?int> Organisation Unit => Cost Centre */
    public function organisationUnitCostCentre(): array
    {
        return $this->makeList($this->organisationUnits, OrganisationUnit::KEY_FIELD, 'costCentre', CostCentre::KEY_FIELD);
    }

    /** @returns array<string, string[]> Organisation Unit => [Child Organisation Units], deeply nested */
    public function organisationUnitHierarchy(): array
    {
        return $this->makeHierarchy($this->organisationUnits);
    }

    /** @return array<string, string[]> Organisation Unit => [Parent Organisation Units] */
    public function organisationUnitParents(): array
    {
        return $this->makeList($this->organisationUnits, OrganisationUnit::KEY_FIELD, 'parents', OrganisationUnit::KEY_FIELD);
    }

    /** @return array<string, string[]> Organisation Unit => [E-mails] */
    public function organisationUnitPeople(): array
    {
        return $this->makeList($this->organisationUnits, OrganisationUnit::KEY_FIELD, 'people', Person::KEY_FIELD);
    }

    /** @return array<string, string[]> Organisation Unit => [Upns] */
    public function organisationUnitUpns(): array
    {
        return $this->makeList($this->organisationUnits, OrganisationUnit::KEY_FIELD, 'upns', Upn::KEY_FIELD);
    }

    // --- People
    /** @returns array<string, string[]> E-mail => [Child E-mails] */
    public function personChildren(): array
    {
        return $this->makeList($this->people, Person::KEY_FIELD, 'children', Person::KEY_FIELD);
    }

    /** @returns array<string, ?int> E-mail => Cost Centre */
    public function personCostCentre(): array
    {
        return $this->makeList($this->people, Person::KEY_FIELD, 'costCentre', CostCentre::KEY_FIELD);
    }

    /** @returns array<string, string[] E-mail => [Child E-mails], deeply nested */
    public function personHierarchy(): array
    {
        return $this->makeHierarchy($this->people);
    }

    /** @returns array<string, string[]> E-mail => Organisation Unit */
    public function personOrganisationUnit(): array
    {
        return $this->makeList($this->people, Person::KEY_FIELD, 'organisationUnit', OrganisationUnit::KEY_FIELD);
    }

    /** @returns array<string, string[]> E-mail => [Parent E-mails] */
    public function personParents(): array
    {
        return $this->makeList($this->people, Person::KEY_FIELD, 'parents', Person::KEY_FIELD);
    }

    /** @returns array<string, ?string> E-mail => Upn */
    public function personUpn(): array
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

    /** @returns array<string, string[]> Upn => [Child Upns], deeply nested */
    public function upnHierarchy(): array
    {
        return $this->makeHierarchy($this->upns);
    }

    /** @returns array<string, string[]> Upn => Organisation Unit */
    public function upnOrganisationUnit(): array
    {
        return $this->makeList($this->upns, Upn::KEY_FIELD, 'organisationUnit', OrganisationUnit::KEY_FIELD);
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
