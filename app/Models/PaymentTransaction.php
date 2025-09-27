<?php

namespace App\Models;

use App\Traits\GenerateUUIDTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentTransaction extends Model
{
    use HasFactory, SoftDeletes, GenerateUUIDTrait;

    protected $fillable = [
        'enrollment_id',
        'amount_deposited',
        'payment_date',
        'external_id',
        'status',   // 🔹 add this so you can store SUCCESS / FAILED from webhook
    ];

    /**
     * A transaction belongs to an enrollment
     */
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function setTransactionId($trans)
    {
        $transSlug = str_replace('-', '', $trans->slug);

        return substr($transSlug, 0, 10);
    }
}
