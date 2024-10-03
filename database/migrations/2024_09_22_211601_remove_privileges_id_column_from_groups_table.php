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
        Schema::table('groups', function (Blueprint $table) {
            $table->dropForeign('groups_privileges_id_foreign');
            $table->dropColumn('privileges_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->unsignedBigInteger('privileges_id')->nullable(); 
            $table->foreign('privileges_id')->references('id')->on('privileges')->onDelete('cascade'); 
        });
    }
};
