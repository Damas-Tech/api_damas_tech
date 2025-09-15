<?php
namespace App\Traits;

trait HasRoles
{
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCompany(): bool
    {
        return $this->role === 'company';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}
