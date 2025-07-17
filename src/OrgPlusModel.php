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

    public const string REQUIRED_KEY = '';

    // Relationships
    public array $children = [];

    public ?OrgPlusModel $parent = null;

    // Construction
    final public function __construct()
    {
        //
    }

    public static function make(array $row): self
    {
        $model = new static();

        foreach (static::FIELD_MAP as $key => $field) {
            if (array_key_exists($key, $row) === true) {
                $model->$field = $model->cast($key, $row[$key]);
            }
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

    // Relationships
    public function addRelation(
        ?OrgPlusModel $model,
        string $relation,
    ): void {
        if ($model === null) {
            return;
        }

        $field = $model::REQUIRED_KEY;
        $key = $model->$field;
        $this->$relation[$key] = $model;
    }
}
