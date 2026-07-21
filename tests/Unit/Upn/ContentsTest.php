<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\Upn;

use NetworkRailBusinessSystems\OrgPlus\Upn;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;

class ContentsTest extends TestCase
{
    protected Upn $upn;

    protected function setUp(): void
    {
        parent::setUp();

        $this->upn = new Upn();
    }

    public function test(): void
    {
        $this->assertEquals(
            $this->upn->people,
            $this->upn->contents(),
        );
    }
}
