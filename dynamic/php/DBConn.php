<?php
    class DBConn{
            private static $obj;
            private static $conn;
    
            private final function  __construct() {
                
            }
    
            public static function getConn() {
                if(!isset(self::$obj)) {
                    self::$obj = new DBConn();
                }
                return self::$obj;
            }

            public static function connect(){
                self::$conn = new mysqli("localhost", "root", "12345678", "linkedindb");
                if (self::$conn->connect_error) {
                    self::$conn->close();
                }
                return self::$conn;
            }

            public static function disconnect(){
                self::$conn->close();
            }
        }
?>