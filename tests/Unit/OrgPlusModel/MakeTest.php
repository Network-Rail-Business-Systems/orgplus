<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlusModel;

use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\Upn;

class MakeTest extends TestCase
{
    protected Upn $model;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = Upn::make([
            Upn::REQUIRED_KEY => 'A123',
            'other_field' => 'nothing',
        ]);
    }

    public function test(): void
    {
        $this->assertEquals('A123', $this->model->code);
        $this->assertObjectNotHasProperty('other_field', $this->model);
    }
}
