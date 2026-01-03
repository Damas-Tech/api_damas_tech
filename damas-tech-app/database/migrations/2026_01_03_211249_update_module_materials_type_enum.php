<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add new column
        Schema::table('module_materials', function (Blueprint $table) {
            $table->string('type_new')->nullable()->after('type');
        });

        // Copy data
        \Illuminate\Support\Facades\DB::statement('UPDATE module_materials SET type_new = type');

        // Drop old
        Schema::table('module_materials', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        // Rename new
        Schema::table('module_materials', function (Blueprint $table) {
            $table->renameColumn('type_new', 'type');
        });
    }

    public function down(): void
    {
        // Basic rollback to string column, can't easily revert to restricted enum
    }
};
