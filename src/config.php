<?php

use NetworkRailBusinessSystems\OrgPlus\CostCentre;
use NetworkRailBusinessSystems\OrgPlus\Person;
use NetworkRailBusinessSystems\OrgPlus\Upn;

return [
    'required_headers' => [
        CostCentre::REQUIRED_KEY,
        Person::REQUIRED_KEY,
        'PARENT_UPN',
        Upn::REQUIRED_KEY,
    ],
];
