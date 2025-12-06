<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, make the column nullable if it's not already
        Schema::table('exams', function (Blueprint $table) {
            $table->unsignedBigInteger('school_class_id')->nullable()->change();
        });

        // Set default value for existing exams (assuming class ID 1 exists)
        DB::table('exams')->whereNull('school_class_id')->update(['school_class_id' => 1]);

        // Now make it not nullable and add the foreign key
        Schema::table('exams', function (Blueprint $table) {
            $table->unsignedBigInteger('school_class_id')->nullable(false)->change();
            $table->foreign('school_class_id')->references('id')->on('classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropForeign(['school_class_id']);
            $table->unsignedBigInteger('school_class_id')->nullable()->change();
        });
    }
};
