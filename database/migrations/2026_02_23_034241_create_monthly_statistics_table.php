<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('monthly_statistics', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->unsignedTinyInteger('month');
            $table->bigInteger('patients_served')->default(0);
            $table->decimal('utilized_funds', 15, 2)->default(0);
            $table->integer('partner_facilities')->default(0);
            $table->date('as_of_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['year', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_statistics');
    }
};
