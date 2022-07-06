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
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enterprise_id')->constrained();
            $table->string('title');
            $table->text('description');
            $table->integer('number_of_positions');
            $table->string('city')->nullable();
            $table->string('type')->nullable();
            $table->string('degree')->nullable();
            $table->boolean('visibility')->default(true);
            $table->date('offer_start_on')->useCurrent();
            $table->date('offer_ends_on')->nullable();
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
        Schema::dropIfExists('job_offers');
    }
};
