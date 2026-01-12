<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = ['name', 'description'];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'payment_method_id');
    }
}
