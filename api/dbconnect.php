<?php
    /**
     * Database Connection
     */
    class dbconnect {
        private $server = 'localhost';
        private $dbname = 'react_app';
        private $user = 'root';
        private $pass = 'root';
        public function connect() {
            try {
                $conn = new PDO('mysql:host=' .$this->server .';dbname=' . $this->dbname, $this->user, $this->pass);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo 'Coucou';
                return $conn;
            } catch (\Exception $e) {
                echo 'Database Error: ' .$e->getMessage();
            }
        }
    }