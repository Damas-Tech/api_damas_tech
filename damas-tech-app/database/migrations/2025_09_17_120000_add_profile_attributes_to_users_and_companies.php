<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (! Schema::hasColumn('users', 'tech_stack')) {
                    $table->json('tech_stack')->nullable()->after('role');
                }
                if (! Schema::hasColumn('users', 'culture_tags')) {
                    $table->json('culture_tags')->nullable()->after('tech_stack');
                }
            });
        }

        if (Schema::hasTable('companies')) {
            Schema::table('companies', function (Blueprint $table) {
                if (! Schema::hasColumn('companies', 'tech_stack')) {
                    $table->json('tech_stack')->nullable()->after('cnpj');
                }
                if (! Schema::hasColumn('companies', 'culture_tags')) {
                    $table->json('culture_tags')->nullable()->after('tech_stack');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'tech_stack')) {
                    $table->dropColumn('tech_stack');
                }
                if (Schema::hasColumn('users', 'culture_tags')) {
                    $table->dropColumn('culture_tags');
                }
            });
        }

        if (Schema::hasTable('companies')) {
            Schema::table('companies', function (Blueprint $table) {
                if (Schema::hasColumn('companies', 'tech_stack')) {
                    $table->dropColumn('tech_stack');
                }
                if (Schema::hasColumn('companies', 'culture_tags')) {
                    $table->dropColumn('culture_tags');
                }
            });
        }
    }
};
