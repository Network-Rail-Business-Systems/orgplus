<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\Upn;

use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\Upn;

class MatchWithParentTest extends TestCase
{
    protected array $library;

    protected Upn $parent;

    protected Upn $upn;

    protected function setUp(): void
    {
        parent::setUp();

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
        $this->upn->matchWithParent($this->library);

        $this->assertEquals(
            'A123',
            $this->upn->parents['A123']->code,
        );

        $this->assertEquals(
            'A234',
            $this->parent->children['A234']->code,
        );
    }

    public function testHandlesNullParent(): void
    {
        $this->upn->parentUpn = null;
        $this->upn->matchWithParent($this->library);

        $this->assertArrayNotHasKey('A123', $this->upn->parents);
        $this->assertArrayNotHasKey('A234', $this->upn->children);
    }

    public function testHandlesMissingParent(): void
    {
        $this->library = [];
        $this->upn->matchWithParent($this->library);

        $this->assertArrayNotHasKey('A123', $this->upn->parents);
        $this->assertArrayNotHasKey('A234', $this->upn->children);
    }
}
