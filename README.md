# OrgPlus

![Composer status](.github/composer.svg)
![Coverage status](.github/coverage.svg)
![Laravel version](.github/laravel.svg)
![NPM status](.github/npm.svg)
![PHP version](.github/php.svg)
![Tests status](.github/tests.svg)

Import the OrgPlus organisational CSV into a structured series of related objects

## Installation

## Usage

Call `$orgPlus = OrgPlus::upload($path)` on the controller where you are uploading the OrgPlus CSV.

The OrgPlus data will be processed and mapped to the relevant objects based on the fields provided.

* Cost Centre (requires `COST_CENTRE` field)
* Person (requires `EMAIL_ADDRESS` field)
* Upn (requires `UPN` field)

These objects are then held in libraries on the OrgPlus object, keyed by their required field.

### Cost Centre ($orgPlus->costCentres)

All information specific to an individual Cost Centre, such as code, people, and Upns.

### Person ($orgPlus->people)

All information specific to an individual Person, such as name, e-mail, Cost Centre, and Upn.

### Upn ($orgPlus->upns)

All information specific to an individual Upn, such as code, job title, grade, Cost Centre, and people.

Bear in mind that a Upn can be shared by any number of people.

Job information is typically held on the Upn, where personal information is held on the Person.

## Relationships and hierarchy

When the relevant fields are available, OrgPlus objects will contain references to other objects.

Both `UPN` and `PARENT_UPN` fields must be provided in the CSV to perform the parent and child hierarchy mapping.

### Cost Centre

Cost Centres are related to:

* Any number of parent Cost Centres
* Any number of child Cost Centres
* Any number of Upns
* Any number of people

### Person

* Any number of parent people
* Any number of child people
* One UPN
* One Cost Centre

### Upn

* Any number of parent Upns
* Any number of child Upns
* One Cost Centre
* Any number of people

## Linked lists

You can parse the libraries of models yourself, or you can produce a linked list of values for quick reference.

These linked lists could be stored for later use in a database, or used immediately to find relevant entries in the libraries.

* Cost Centre children
* Cost Centre hierarchy
* Cost Centre parents
* Cost Centre People
* Cost Centre Upns
* Person children
* Person Cost Centre
* Person hierarchy
* Person parents
* Person Upn
* Upn children
* Upn hierarchy
* Upn parents
* Upn Cost Centre
* Upn People

When outputting linked lists, only the first occurrence of an object within a tree section is used to prevent infinite looping.

## Roadmap

* Grade filtering
* Organisation Units
* Nested set
