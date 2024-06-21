<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CustomerPayment extends Model
{
    use HasFactory;
    public function process_balance($m)
    {
        $invo = Invoice::find($m->invoice_id);
        if ($invo == null) {
            throw new Exception("Invoice not found.", 1);
        }

        $invo->balance += $m->amount;
        if ($invo->balance > -1) {
            // $invo->fully_paid = 'Yes';
        } else {
            // $invo->fully_paid = 'No';
        }
        $invo->save();
        // $m->customer->update_balance();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoicing()
    {
        return $this->belongsTo(Invoice::class);
    }

    public static function boot()
    {
        parent::boot();
        self::created(function ($m) {
            $m->process_balance($m);
            $customer = Customer::find($m->customer_id);
            if ($customer == null) {
                throw new Exception("Customer not found.", 1);
                return;
            }
            if ($customer == null) {
               
            } else {
                $customer->update_balance();
            }

            $total_paid = $m->invoicing->payments->sum('amount');
            $balance =  $total_paid - $m->invoicing->payable_amount;
            $m->invoicing->balance = $balance;
            $m->invoicing->save();
            DB::table('customer_payments')->where('id', $m->id)->update(['balance' => $balance]);
            $customer->update_balance();
            return $m;
        });
        self::updated(function ($m) {
            $m->process_balance($m);
            $customer = Customer::find($m->customer_id);
            if ($customer == null) {
                throw new Exception("Customer not found.", 1);
            }

            $total_paid = $m->invoicing->payments->sum('amount');
            $balance =  $total_paid - $m->invoicing->payable_amount;
            $m->invoicing->balance = $balance;
            $m->invoicing->save();
            DB::table('customer_payments')->where('id', $m->id)->update(['balance' => $balance]);

            $customer->update_balance();
            return $m;
        });

        self::updated(function ($m) {
            $m->process_balance($m);
            $customer = Customer::find($m->customer_id);
            if ($customer == null) {
                throw new Exception("Customer not found.", 1);
            }

            $total_paid = $m->invoicing->payments->sum('amount');
            $balance =  $total_paid - $m->invoicing->payable_amount;
            $m->invoicing->balance = $balance;
            $m->invoicing->save();
            DB::table('customer_payments')->where('id', $m->id)->update(['balance' => $balance]);

            $customer->update_balance();
            return $m;
        });

        self::deleted(function ($m) {
            $customer = Customer::find($m->customer_id);
            if ($customer == null) {
                throw new Exception("Customer not found.", 1);
            }

            $total_paid = $m->invoicing->payments->sum('amount');
            $balance =  $total_paid - $m->invoicing->payable_amount;
            $m->invoicing->balance = $balance;
            $m->invoicing->save();
            DB::table('customer_payments')->where('id', $m->id)->update(['balance' => $balance]);

            $customer->update_balance();
            return $m;
        });
    }
}
