<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlus\Import;

use NetworkRailBusinessSystems\OrgPlus\OrgPlus;
use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\Upn;

class GatherModelTest extends TestCase
{
    protected OrgPlus $orgPlus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orgPlus = new OrgPlus();
    }

    public function testNullWhenRequiredKeyMissing(): void
    {
        $this->assertNull(
            $this->orgPlus->gatherModel(
                Upn::class,
                'upns',
                [
                    'none' => false,
                ],
            ),
        );
    }

    public function testNullWhenRequiredKeyBlank(): void
    {
        $this->assertNull(
            $this->orgPlus->gatherModel(
                Upn::class,
                'upns',
                [
                    Upn::REQUIRED_KEY => null,
                ],
            ),
        );
    }

    public function testReturnsExisting(): void
    {
        $upn = new Upn();
        $upn->code = 'B123';

        $this->orgPlus->upns['A123'] = $upn;

        $this->assertEquals(
            'B123',
            $this->orgPlus->gatherModel(
                Upn::class,
                'upns',
                [
                    Upn::REQUIRED_KEY => 'A123',
                ],
            )->code,
        );
    }

    public function testReturnsNew(): void
    {
        $this->assertEquals(
            'A123',
            $this->orgPlus->gatherModel(
                Upn::class,
                'upns',
                [
                    Upn::REQUIRED_KEY => 'A123',
                ],
            )->code,
        );
    }
}
