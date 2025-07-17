<?php

namespace NetworkRailBusinessSystems\OrgPlus;

/**
 * @property array<string, OrgPlusModel> $children
 * @property ?OrgPlusModel $parent
 */
abstract class OrgPlusModel
{
    public const array CAST_MAP = [];

    public const array FIELD_MAP = [];

    public array $children = [];

    public ?OrgPlusModel $parent = null;

    final public function __construct()
    {
        //
    }

    public static function make(array $row): self
    {
        $model = new static();

        foreach ($row as $key => $value) {
            $field = static::FIELD_MAP[$key];
            $model->$field = $model->cast($key, $value);
        }

        return $model;
    }

    public function cast(string $key, ?string $value): string|int|bool|null
    {
        return match (static::CAST_MAP[$key]) {
            'bool' => $value === 'Y',
            'int' => empty($value) === false
                ? (int) $value
                : null,
            default => $value,
        };
    }
}
