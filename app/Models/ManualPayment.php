<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualPayment extends Model
{
    use HasFactory;
    protected $primaryKey = 'reference';
    protected $guarded = ['id'];

    protected $casts = ['is_anonim' => 'boolean'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_id');
    }
    public function validator()
    {
        return $this->belongsTo(User::class, 'validator_id');
    }
}
