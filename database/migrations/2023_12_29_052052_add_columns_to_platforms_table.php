<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPlatformsTable extends Migration
{
    public function up()
    {
        Schema::table('platforms', function (Blueprint $table) {
            $table->string('showTitle')->nullable();
            $table->string('showThumb')->nullable();
            // Add your new columns with appropriate data types
        });
    }

    public function down()
    {
        Schema::table('platforms', function (Blueprint $table) {
            $table->dropColumn('showTitle');
            $table->dropColumn('showThumb');
            // Rollback: Drop the added columns in the down method if needed
        });
    }
}
