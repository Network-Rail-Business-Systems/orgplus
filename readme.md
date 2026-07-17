# OrgPlus

![Composer status](.github/composer.svg)
![Coverage status](.github/coverage.svg)
![Laravel version](.github/laravel.svg)
![NPM status](.github/npm.svg)
![PHP version](.github/php.svg)
![Tests status](.github/tests.svg)

Import the OrgPlus organisational CSV into a structured series of related objects

[Upgrade guide](docs/upgrade.md)

## Usage

Call `$orgPlus = OrgPlus::upload($file)` on the controller where you are uploading the OrgPlus CSV.

The `$file` variable can be either a `UploadedFile` or a string path.

The OrgPlus data will be processed and mapped to the relevant objects based on the fields provided.

* Cost Centre (requires `COST_CENTRE` field)
* Organisation Unit (requires `ORG` field)
* Person (requires `EMAIL_ADDRESS` field)
* Upn (requires `UPN` field)

These objects are then held in libraries on the OrgPlus object, keyed by their required field.

### Cost Centre ($orgPlus->costCentres)

All information specific to an individual Cost Centre, such as number, people, and Upns.

### Organisation Unit ($orgPlus->organisationUnits)

All information specific to an individual Organisation Unit, such as name and Upns.

### Person ($orgPlus->people)

All information specific to an individual Person, such as name, e-mail, Cost Centre, and Upn.

### Upn ($orgPlus->upns)

All information specific to an individual Upn, such as code, job title, grade, Organisation Unit, and people.

Bear in mind that a Upn can be shared by any number of people.

Job information is typically held on the Upn, where personal information is held on the Person.

## Relationships and hierarchy

When the relevant fields are available, OrgPlus objects will contain references to other objects.

Both `UPN` and `PARENT_UPN` fields must be provided in the CSV to perform the parent and child hierarchy mapping.

Objects are structured as follows:

```
Cost Centre -> Organisation Unit -> Upn -> Person
```

The required fields for each model must be included to complete the hierarchy map.

### Organisation Unit

Organisation Units are related to:

* Any number of parent Organisation Units
* Any number of child Organisation Units
* Any number of Cost Centres
* Any number of Upns
* Any number of people

### Cost Centre

Cost Centres are related to:

* Any number of parent Cost Centres
* Any number of child Cost Centres
* One Organisation Unit
* Any number of Upns
* Any number of people

### Upn

* Any number of parent Upns
* Any number of child Upns
* One Cost Centre
* One Organisation Unit
* Any number of people

### Person

* Any number of parent people
* Any number of child people
* One Cost Centre
* One Organisation Unit
* One UPN

## Linked lists

You can parse the libraries of models yourself, or you can produce a linked list of values for quick reference.

These linked lists could be stored for later use in a database, or used immediately to find relevant entries in the libraries.

### Cost Centre
* Cost Centre children
* Cost Centre hierarchy
* Cost Centre parents
* Cost Centre Organisation Units
* Cost Centre Upns
* Cost Centre People

### Organisation Unit
* Organisation Unit children
* Organisation Unit hierarchy
* Organisation Unit parents
* Organisation Unit Cost Centre
* Organisation Unit Upns
* Organisation Unit People

### Upn
* Upn children
* Upn hierarchy
* Upn parents
* Upn Cost Centre
* Upn Organisation Unit
* Upn People

### Person
* Person children
* Person hierarchy
* Person parents
* Person Cost Centre
* Person Organisation Unit
* Person Upn

When outputting linked lists, only the first occurrence of an object within a tree section is used to prevent infinite looping.

## Adjacency lists

You can create adjacency lists for hierarchical queries and lookups using the following methods:

| Method                    | Key     | Value                    |
|---------------------------|---------|--------------------------|
| costCentreAdjacency       | 12345   | /12345/23456/34567       |
| organisationUnitAdjacency | Aaa     | /Aaa/Bbb/Ccc             |
| personAdjacency           | a@b.com | /a@b.com/b@c.com/c@d.com |
| personUpnAdjacency        | a@b.com | /A123/A234/A345          |
| upnAdjacency              | A123    | /A123/A234/A345          |

The delimiter, `/` by default, can be customised as needed.
