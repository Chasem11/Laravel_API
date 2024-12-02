<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentItemProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS rentItem;');
        DB::unprepared("
        CREATE DEFINER=`root`@`localhost` PROCEDURE `rentItem`(
            in renter_id_input int,
            in book_id_input int,
            in movie_id_input int
        )
        begin
            declare available int;
            declare userType varchar(255);
            declare currentRentals int;
            
            select user_type into userType from Users where user_id = renter_id_input;
            select count(*) into currentRentals
            from Rentals
            where renter_id = renter_id_input and returned = FALSE;
            
            if (userType = 'Student' and currentRentals < 2) or (userType = 'Teacher' and currentRentals < 4) then
                if book_id_input is not null then
                    select availability into available from books where item_id = book_id_input;
                    if available = 1 then
                        update books set availability = false where item_id = book_id_input;
                        insert into rentals (rental_date, return_date, returned, renter_id, book_id, movie_id) 
                        values (curdate(), NULL, FALSE, renter_id_input, book_id_input, NULL);
                    else
                        signal sqlstate '45000' set message_text = 'Book is not available';
                    end if;
                end if;
                
                if movie_id_input is not null then
                    select availability into available from movies where item_id = movie_id_input;
                    if available = 1 then
                        update movies set availability = false where item_id = movie_id_input;
                        insert into rentals (rental_date, return_date, returned, renter_id, book_id, movie_id) 
                        values (curdate(), NULL, FALSE, renter_id_input, NULL, movie_id_input);
                    else
                        signal sqlstate '45000' set message_text = 'Movie is not available';
                    end if;
                end if;
            else
                signal sqlstate '45000' set message_text = 'Rental limit reached';
            end if;
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
