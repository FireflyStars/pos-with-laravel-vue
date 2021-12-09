<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateApiSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_sessions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('api_id');
            $table->string('sessionid');
            $table->enum('sessiontype',['login','token']);
            $table->dateTime('last_activity');
            $table->timestamps();
        });

        DB::unprepared('
        CREATE TRIGGER `lcdtapp_api_sessions_bi` BEFORE INSERT ON `api_sessions` FOR EACH ROW
            BEGIN
                SET NEW.sessionid= UUID(); 
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        DB::unprepared('DROP TRIGGER `lcdtapp_api_sessions_bi`');
        Schema::dropIfExists('api_sessions');
    }
}
