<?php

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_payments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Invoice::class)->nullable();
            $table->foreignIdFor(Customer::class);
            $table->integer('amount');
            $table->integer('balance');
            $table->text('details')->nullable();
            $table->text('payment_method')->nullable();
            $table->text('payment_destination')->nullable();
            $table->text('transaction_number')->nullable();
            $table->text('account_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_payments');
    }
}
