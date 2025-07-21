<?php

namespace NetworkRailBusinessSystems\OrgPlus;

/**
 * @property array<string, OrgPlusModel> $children
 * @property array<string, OrgPlusModel> $parents
 */
abstract class OrgPlusModel
{
    public const array CAST_MAP = [];

    public const array FIELD_MAP = [];

    public const string REQUIRED_KEY = '';

    public const string KEY_FIELD = '';

    // Relationships
    public array $children = [];

    public array $parents = [];

    // Construction
    final public function __construct()
    {
        //
    }

    public static function make(array $row): static
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
    abstract public function matchWithParent(array $library = []): void;

    public function addRelation(
        ?OrgPlusModel $model,
        string $relation,
    ): void {
        if ($model === null) {
            return;
        }

        if (is_array($this->$relation) === true) {
            $field = $model::FIELD_MAP[$model::REQUIRED_KEY];
            $key = $model->$field;
            $this->$relation[$key] = $model;
        } else {
            $this->$relation = $model;
        }
    }

    public function addChild(OrgPlusModel $child): void
    {
        $this->addRelation($child, 'children');
    }

    public function addParent(OrgPlusModel $parent): void
    {
        $this->addRelation($parent, 'parents');
    }

    public function mapChildren(array &$map): array
    {
        $key = static::KEY_FIELD;
        $map[$this->$key] = [];

        foreach ($this->children as $child) {
            $child->mapChildren($map[$this->$key]);
        }

        return $map;
    }
}
