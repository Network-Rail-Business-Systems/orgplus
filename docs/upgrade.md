# Upgrade guide

## Upgrading to 2.x from 1.x

* The `code` property on the `CostCentre` model has been changed to `number`
* A model has been added for `OrganisationUnit` which sits between `CostCentre` and `Upn`
* You must include the `Org` property to use the `OrganisationUnit` model
* `OrgPlus::personCostCentres()` has been corrected to `personCostCentre()`
* `OrgPlus::personUpns()` has been corrected to `personUpn()`
