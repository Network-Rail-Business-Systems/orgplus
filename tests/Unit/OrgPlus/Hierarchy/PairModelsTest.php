<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\Hierarchy;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\Upn;

class PairModelsTest extends TestCase
{
    protected array $library;

    protected OrgPlus $orgPlus;

    protected Upn $parent;

    protected Upn $upn;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orgPlus = new OrgPlus();

        $this->upn = new Upn();
        $this->upn->code = 'A234';
        $this->upn->parentUpn = 'A123';

        $this->parent = new Upn();
        $this->parent->code = 'A123';

        $this->library = [
            'A123' => $this->parent,
            'A234' => $this->upn,
        ];
    }

    public function test(): void
    {
        $this->orgPlus->pairModels($this->library, $this->library);

        $this->assertEquals(
            'A123',
            $this->upn->parents['A123']->code,
        );

        $this->assertEquals(
            'A234',
            $this->parent->children['A234']->code,
        );
    }

    public function testHandlesEmptyLibrary(): void
    {
        $this->library = [];

        $this->orgPlus->pairModels($this->library);

        $this->assertEmpty($this->upn->parents);
        $this->assertEmpty($this->parent->children);
    }
}
