<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('material_progresses', function (Blueprint $table) {
            // Tambahkan kolom is_completed (boolean) dan score (integer)
            $table->boolean('is_completed')->default(false)->after('material_id');
            $table->integer('score')->nullable()->after('is_completed');
        });
    }

    public function down()
    {
        Schema::table('material_progresses', function (Blueprint $table) {
            // Hapus kolom jika di-rollback
            $table->dropColumn(['is_completed', 'score']);
        });
    }
};