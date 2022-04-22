<?php

namespace App\Domain\Secrets\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secret extends Model
{
    use HasFactory;

    public function hasExpired(): bool
    {
        return $this->created_at->diffInSeconds() > $this->ttl;
    }
}
