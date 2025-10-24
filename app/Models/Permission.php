<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'guard_name',
        'group',
        'description',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }

    public static function createPermission(string $name, string $group = null, string $description = null, string $guardName = 'web'): self
    {
        return static::create([
            'name' => $name,
            'guard_name' => $guardName,
            'group' => $group,
            'description' => $description,
        ]);
    }

    public static function getPermissionsByGroup(): array
    {
        return static::orderBy('group')->orderBy('name')->get()->groupBy('group')->toArray();
    }
}
