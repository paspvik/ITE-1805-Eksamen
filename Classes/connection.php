<?php

/* SOURCE OOP https://www.youtube.com/watch?v=B1_yi7HM0Cg */

class Connection {

    public function dbConnect() {
        return new PDO("mysql:host=kark.uit.no;dbname=stud_v19_aspvikp", "stud_v19_aspvikp",
        "mariadb@uit");
    }
}


