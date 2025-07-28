<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\Upn;

use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\Upn;

class MatchWithRelatedTest extends TestCase
{
    protected array $library;

    protected Upn $parent;

    protected Upn $upn;

    protected function setUp(): void
    {
        parent::setUp();

        $this->upn = new Upn();
        $this->upn->code = 'A234';
        $this->upn->orgHrManager = 'A123';

        $this->parent = new Upn();
        $this->parent->code = 'A123';
        $this->parent->orgHrManager = 'A234';

        $this->library = [
            'A123' => $this->parent,
            'A234' => $this->upn,
        ];
    }

    public function test(): void
    {
        $this->upn->matchWithRelated([], [], $this->library);

        $this->assertEquals(
            'A123',
            $this->upn->hrManager->code,
        );

        $this->assertEquals(
            'A234',
            $this->parent->hrManages['A234']->code,
        );
    }

    public function testHandlesNullRelation(): void
    {
        $this->upn->orgHrManager = null;
        $this->upn->matchWithRelated([], [], $this->library);

        $this->assertNull($this->upn->hrManager);
        $this->assertEmpty($this->parent->hrManages);
    }

    public function testHandlesMissingRelation(): void
    {
        $this->library = [];
        $this->upn->matchWithRelated([], [], $this->library);

        $this->assertNull($this->upn->hrManager);
        $this->assertEmpty($this->parent->hrManages);
    }
}
