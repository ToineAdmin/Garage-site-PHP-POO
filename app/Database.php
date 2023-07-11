<?php

namespace App;

use \PDO;


class Database{

    private $db_name;
    private $db_user;
    private $db_pass;
    private $db_host;
    private $pdo;

    public function __construct($db_name, $db_user = 'root', $db_pass = '', $db_host= 'localhost')
    {
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
    }

    //Methode pour conexion à la base de donnée
    private function getPDO(){

        if($this->pdo === null){
            $pdo = new PDO('mysql:dbname=db_garage;host=localhost', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // récupère les erreurs sql qui par défaut ne sont pas affichées
            $this->pdo = $pdo;
        }

        return $this->pdo;
    }

    public function query($statement){
        $stmt = $this->getPDO()->query($statement);
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    // public function insertInto($insertion){
    //     $insertion = $_POST;
    //     $stmt = $this->getPDO()->
    // }
}