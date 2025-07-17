# OrgPlus
Import the OrgPlus organisational CSV into a structured series of related objects

## Installation

## Usage

Call `$orgPlus = OrgPlus::upload($path)` on the controller where you are uploading the OrgPlus CSV.

The OrgPlus data will be processed and mapped to the relevant objects based on the fields provided.

* Cost Centre (requires `COST_CENTRE` field)
* Person (requires `EMAIL_ADDRESS` field)
* Upn (requires `UPN` field)

## Relationships

When the relevant fields are available, OrgPlus objects will contain references to other objects.

Both `UPN` and `PARENT_UPN` fields must be provided in the CSV to perform the parent and child mapping.

### Cost Centre

Cost Centres are related to:

* One parent Cost Centre
* Any number of child Cost Centres
* Any number of Upns
* Any number of Persons

### Person

* One parent Person
* Any number of child Persons
* One UPN
* One Cost Centre

### Upn

* One parent Upn
* Any number of child Upns
* One Cost Centre
* Any number of People
