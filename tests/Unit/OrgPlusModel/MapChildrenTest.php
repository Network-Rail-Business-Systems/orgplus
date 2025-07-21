<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlusModel;

use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\Upn;

class MapChildrenTest extends TestCase
{
    protected array $map = [];

    protected Upn $model;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new Upn();
        $this->model->code = 'A123';

        $childOne = new Upn();
        $childOne->code = 'A234';

        $childTwo = new Upn();
        $childTwo->code = 'A345';

        $grandchild = new Upn();
        $grandchild->code = 'A456';

        $this->model->addChild($childOne);
        $this->model->addChild($childTwo);
        $childOne->addChild($grandchild);

        $this->model->mapChildren($this->map);
    }

    public function test(): void
    {
        $this->assertEquals(
            [
                'A123' => [
                    'A234' => [
                        'A456' => [],
                    ],
                    'A345' => [],
                ],
            ],
            $this->map,
        );
    }
}
