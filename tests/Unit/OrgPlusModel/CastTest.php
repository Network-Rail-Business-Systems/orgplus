<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests\Unit\OrgPlusModel;

use NetworkRailBusinessSystems\OrgPlus\Tests\TestCase;
use NetworkRailBusinessSystems\OrgPlus\Upn;
use PHPUnit\Framework\Attributes\DataProvider;

class CastTest extends TestCase
{
    protected Upn $model;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new Upn();
    }

    #[DataProvider('expectations')]
    public function test(string $key, ?string $value, string|int|bool|null $expected): void
    {
        $this->assertEquals(
            $expected,
            $this->model->cast($key, $value),
        );
    }

    public static function expectations(): array
    {
        return [
            [
                'key' => Upn::REQUIRED_KEY,
                'value' => 'A123',
                'expected' => 'A123',
            ],
            [
                'key' => 'A2C_LIMIT',
                'value' => '1234',
                'expected' => 1234,
            ],
            [
                'key' => 'A2C_LIMIT',
                'value' => null,
                'expected' => null,
            ],
            [
                'key' => 'POS_JOB_REQUIREMENT_CAR',
                'value' => 'Y',
                'expected' => true,
            ],
            [
                'key' => 'POS_JOB_REQUIREMENT_CAR',
                'value' => 'N',
                'expected' => false,
            ],
        ];
    }
}
