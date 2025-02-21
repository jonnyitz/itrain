<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('cuotas', function (Blueprint $table) {
        $table->unsignedBigInteger('proyecto_id')->nullable()->after('contacto_id');
        $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('cuotas', function (Blueprint $table) {
        $table->dropForeign(['proyecto_id']);
        $table->dropColumn('proyecto_id');
    });
}
};
