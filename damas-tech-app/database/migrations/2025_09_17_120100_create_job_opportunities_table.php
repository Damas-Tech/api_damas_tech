<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('job_opportunities')) {
            return;
        }

        Schema::create('job_opportunities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('tech_stack')->nullable();
            $table->json('culture_tags')->nullable();
            $table->string('location_type')->nullable(); // remote, hybrid, onsite
            $table->string('seniority')->nullable();
            $table->string('status')->default('open'); // open, closed, draft
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_opportunities');
    }
};
