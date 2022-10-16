<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("employee")->length(5);
            $table->string("contact",10)->unique();
            $table->timestamps();
            $table->foreign('employee')
                 ->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees_contacts');
    }
};
