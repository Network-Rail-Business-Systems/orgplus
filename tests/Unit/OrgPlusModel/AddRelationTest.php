<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlusModel;

use NetworkRailBusinessSystems\OrgPlus\CostCentre;
use NetworkRailBusinessSystems\OrgPlus\Person;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\Upn;

class AddRelationTest extends TestCase
{
    protected CostCentre $costCentre;

    protected Person $person;

    protected Upn $model;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new Upn();

        $this->costCentre = new CostCentre();
        $this->costCentre->code = 12345;

        $this->person = new Person();
        $this->person->email = 'a@b.com';
    }

    public function testNull(): void
    {
        $this->model->addRelation(null, 'people');

        $this->assertEmpty($this->model->people);
    }

    public function testOne(): void
    {
        $this->model->addRelation($this->costCentre, 'costCentre');

        $this->assertEquals(
            $this->costCentre->code,
            $this->model->costCentre->code,
        );
    }

    public function testMany(): void
    {
        $this->model->addRelation($this->person, 'people');

        $this->assertCount(1, $this->model->people);

        $this->assertEquals(
            $this->person->email,
            $this->model->people[$this->person->email]->email,
        );
    }
}
