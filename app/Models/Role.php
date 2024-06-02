<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Spatie\Translatable\HasTranslations;

class Role extends \Spatie\Permission\Models\Role
{
    use ModelTrait;

    use HasTranslations;
    public $translatable = ['name'];
    public $searchable = ['name'];

    public const DEFAULT_ROLE_SUPER_ADMIN = 'admin';
    public const DEFAULT_ROLE_CLIENT = 'client';


    protected array $filters = [
        'name',
        'status',
    ];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public array $definedRelations = ['users'];


    public function scopeOfName($query, $keyword)
    {
        $name = 'name';
        $query->whereRaw("JSON_VALID({$name}) AND JSON_EXTRACT({$name}, '$.ar') like '%{$keyword}%'")
            ->orWhereRaw("JSON_VALID({$name}) AND lower(JSON_EXTRACT({$name}, '$.en')) like '%{$keyword}%'");
    }

    public function scopeOfStatus($query, $value)
    {
        if (($value == 'both' || empty($value)) && $value != 0) {
            return $query;
        }
        return $query->where('is_active', $value);
    }
}
