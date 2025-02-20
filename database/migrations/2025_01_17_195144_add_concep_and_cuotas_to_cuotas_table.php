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
            $table->string('concep')->nullable(); // O el tipo que necesites
            $table->decimal('cuotas', 8, 2)->nullable(); // O el tipo que necesites
        });
    }
    
    public function down()
    {
        Schema::table('cuotas', function (Blueprint $table) {
            $table->dropColumn('concep');
            $table->dropColumn('cuotas');
        });
    }
    
};
