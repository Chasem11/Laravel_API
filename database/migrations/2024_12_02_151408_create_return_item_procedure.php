<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnItemProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS returnItem;');
        DB::unprepared("
        CREATE DEFINER=`root`@`localhost` PROCEDURE `returnItem`(
            in rental_id_input int
        )
        begin
            declare book_id_input int;
            declare movie_id_input int;
            select book_id, movie_id into book_id_input, movie_id_input from rentals where id = rental_id_input;

            if book_id_input is not null then
                update books set availability = true where item_id = book_id_input;
            elseif movie_id_input is not null then
                update movies set availability = true where item_id = movie_id_input;
            end if;
            update rentals set return_date = curdate() where id = rental_id_input;
            update rentals set returned = TRUE where id = rental_id_input;
        end
         ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS rentItem');
    }
}
