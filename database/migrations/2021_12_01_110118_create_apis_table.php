<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apis', function (Blueprint $table) {
            $table->id();
            $table->string('securityid',100)->unique();
            $table->string('accountkey',100)->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::unprepared('
        CREATE TRIGGER `lcdtapp_api_bi` BEFORE INSERT ON `apis` FOR EACH ROW
            BEGIN
                SET NEW.securityid= UUID(); 
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

   
        DB::unprepared('DROP TRIGGER `lcdtapp_api_bi`');
    
        Schema::dropIfExists('apis');
    }
}
