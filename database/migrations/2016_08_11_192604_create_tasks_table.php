<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');

						$table->integer('user_id')->unsigned()->nullable();

						$table->string('title');
						$table->boolean('completed');

            $table->timestamps();

						$table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

		
    public function down()
    {
			Schema::table('tasks', function (Blueprint $table)
			{
					$table->dropForeign('tasks_user_id_foreign');
			});

			Schema::drop('tasks');
    }
}
