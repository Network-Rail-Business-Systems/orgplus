# OrgPlus
Import the OrgPlus organisational CSV into a structured series of related objects

## Installation

## Usage

Call `$orgPlus = OrgPlus::upload($path)` on the controller where you are uploading the OrgPlus CSV.

The OrgPlus data will be processed and mapped to the relevant objects based on the fields provided.

* Cost Centre (requires `COST_CENTRE` field)
* Person (requires `EMAIL_ADDRESS` field)
* Upn (requires `UPN` field)

### Cost Centre

All information specific to an individual Cost Centre, such as code, people, and Upns.

### Person

All information specific to an individual Person, such as name, e-mail, Cost Centre, and Upn.

### Upn

All information specific to an individual Upn, such as code, job title, grade, Cost Centre, and people.

Bear in mind that a Upn can be shared by any number of people.

Job information is typically held on the Upn, where personal information is held on the Person.

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

## Roadmap

* Base related object import
* Hierarchy linking
* Output rainbow lists
* Grade filtering
* Organisation Units
