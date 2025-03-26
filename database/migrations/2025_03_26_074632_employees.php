<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Employees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');

            $table->string('group')->nullable();
            $table->json('additional_roles')->nullable();
            $table->boolean('is_active')->default(true);

            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('oib')->nullable();

            $table->date('agreement_start_date')->nullable();
            $table->date('agreement_end_date')->nullable();
            $table->string('agreement_file')->nullable();

            $table->decimal('net_salary', 10, 2)->nullable();
            $table->decimal('gross_salary', 10, 2)->nullable();
            $table->decimal('bonus', 10, 2)->nullable();

            $table->text('additional_message')->nullable();
            $table->string('warehouse')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
