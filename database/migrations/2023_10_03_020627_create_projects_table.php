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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('industry_partner_id'); // Foreign key referencing industry_partners table
            $table->string('title');
            $table->text('description');
            $table->integer('team_size');
            $table->integer('trimester');
            $table->integer('year');
            $table->foreign('industry_partner_id')->references('id')->on('industry_partners');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
