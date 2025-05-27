<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Customer extends Model
{
    protected $table = "customer";

    protected $primaryKey = 'cus_id';
    protected $guarded = [];

    public function getDecryptedCustomerNameAttribute()
    {
        try {
            return $this->customer_name ? Crypt::decryptString($this->customer_name) : 'Không rõ';
        } catch (\Exception $e) {
            return 'Không rõ';
        }
    }

    public function getDecryptedCustomerPayAttribute()
    {
        try {
            return $this->customer_pay ? Crypt::decryptString($this->customer_pay) : 'Không rõ';
        } catch (\Exception $e) {
            return 'Không rõ';
        }
    }

    public function getDecryptedCustomerPhoneAttribute()
    {
        try {
            return $this->customer_phone ? Crypt::decryptString($this->customer_phone) : 'Không rõ';
        } catch (\Exception $e) {
            return 'Không rõ';
        }
    }

    public function getDecryptedCustomerAddressAttribute()
    {
        try {
            return $this->customer_address ? Crypt::decryptString($this->customer_address) : 'Không rõ';
        } catch (\Exception $e) {
            return 'Không rõ';
        }
    }

    public function getDecryptedCustomerEmailAttribute()
    {
        try {
            return $this->customer_email ? Crypt::decryptString($this->customer_email) : 'Không rõ';
        } catch (\Exception $e) {
            return 'Không rõ';
        }
    }

    public function getDecryptedCustomerNoteAttribute()
    {
        try {
            return $this->customer_note ? Crypt::decryptString($this->customer_note) : 'Không có ghi chú';
        } catch (\Exception $e) {
            return 'Không có ghi chú';
        }
    }
}
