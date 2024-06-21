<?php

use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_statements', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Customer::class);
            $table->text('customer_name')->nullable();
            $table->text('customer_email')->nullable();
            $table->text('customer_phone')->nullable();
            $table->text('customer_address')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('regenerate_report')->nullable();
            $table->bigInteger('total_income')->nullable();
            $table->bigInteger('amount_due')->nullable();
            $table->bigInteger('total_payment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_statements');
    }
}
