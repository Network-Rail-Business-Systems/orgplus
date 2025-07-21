<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlusModel;

use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\Upn;

class AddParentTest extends TestCase
{
    protected Upn $model;

    protected Upn $parent;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new Upn();

        $this->parent = new Upn();
        $this->parent->code = 'A234';
    }

    public function test(): void
    {
        $this->model->addParent($this->parent);

        $this->assertCount(1, $this->model->parents);

        $this->assertEquals(
            $this->parent->code,
            $this->model->parents[$this->parent->code]->code,
        );
    }
}
