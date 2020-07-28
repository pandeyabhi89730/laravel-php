<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_employees', function (Blueprint $table) {
            $table->increments ('id');
            $table->string('first_name');
            $table->string('middle_name');
             $table->string('last_name');
              $table->string('desiganation')->nullable();
               $table->date('date_of_joining');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_employees');
    }
}
