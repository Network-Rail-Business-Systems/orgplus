<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlusModel;

use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\Upn;

class AddChildTest extends TestCase
{
    protected Upn $child;

    protected Upn $model;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new Upn();

        $this->child = new Upn();
        $this->child->code = 'A234';
    }

    public function test(): void
    {
        $this->model->addChild($this->child);

        $this->assertCount(1, $this->model->children);

        $this->assertEquals(
            $this->child->code,
            $this->model->children[$this->child->code]->code,
        );
    }
}
