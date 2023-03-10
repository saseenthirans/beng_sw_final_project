<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    public function customers()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id')->withTrashed();
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->withTrashed();
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id','id');
    }

    public function invoicePayment()
    {
        return $this->hasMany(InvoicePayment::class, 'invoice_id','id');
    }

    public function firstPayment()
    {
        return $this->hasOne(InvoicePayment::class, 'invoice_id','id')->orderBy('id','ASC')->first();
    }
}
