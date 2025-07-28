<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\Upn;

use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\Upn;

class AddHrManagesTest extends TestCase
{
    protected Upn $upn;

    protected Upn $hrManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hrManager = new Upn();
        $this->hrManager->code = 'A123';

        $this->upn = new Upn();
        $this->upn->addHrManages($this->hrManager);
    }

    public function test(): void
    {
        $this->assertEquals(
            'A123',
            $this->upn->hrManages['A123']->code,
        );
    }
}
