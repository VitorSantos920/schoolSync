<?php
require_once(realpath(dirname(__FILE__, 2)) . '/vendor/sergeytsalkov/meekrodb/db.class.php');

DB::$user = 'root';
DB::$host = 'localhost';
DB::$password = '';
DB::$dbName = 'school_sync';
DB::$encoding = 'utf8mb4';
