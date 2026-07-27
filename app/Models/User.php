<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLES = [
        'admin' => 'Administrator',
        'sales' => 'Sales',
        'project_manager' => 'Project Manager',
        'project_head' => 'Project Head',
        'project_coordinator' => 'Project Coordinator',
        'site_manager' => 'Site Manager',
        'site_supervisor' => 'Site Supervisor',
        'supervisor' => 'Supervisor',
        'security' => 'Security',
        'office_staff' => 'Office Staff',
        'inventory_manager' => 'Inventory Manager',
        'workshop_manager' => 'Workshop Manager',
        'accounts' => 'Accounts',
    ];

    protected $fillable = [
        'photo',
        'name',
        'email',
        'mobile',
        'password',
        'role',
        'department',
        'status',
        'address',
        'remarks',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function roles(): array
    {
        return self::ROLES;
    }

    /**
     * A safe name for portal headers. Spreadsheet-style imports and some
     * integrations may store placeholders such as "nan" for an empty name.
     */
    public function getDisplayNameAttribute(): string
    {
        $name = trim((string) $this->name);

        if ($name !== '' && ! in_array(strtolower($name), ['nan', 'null', 'undefined', 'n/a'], true)) {
            return $name;
        }

        $emailName = trim((string) str($this->email)->before('@')->replace(['.', '_', '-'], ' ')->title());

        return $emailName !== '' ? $emailName : 'Security User';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}