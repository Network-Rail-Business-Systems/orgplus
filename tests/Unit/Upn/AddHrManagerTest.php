<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\Upn;

use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\Upn;

class AddHrManagerTest extends TestCase
{
    protected Upn $upn;

    protected Upn $hrManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hrManager = new Upn();
        $this->hrManager->code = 'A123';

        $this->upn = new Upn();
        $this->upn->addHrManager($this->hrManager);
    }

    public function test(): void
    {
        $this->assertEquals(
            'A123',
            $this->upn->hrManager->code,
        );
    }
}
