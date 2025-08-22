<?php

class m0001_initial{
    public function up(){

    $db = \app\core\Application::$app->db;
    $SQL = "CREATE TABLE users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        email VARCHAR(55) NOT NULL,
        firstname VARCHAR(55) NOT NULL,
        lastname VARCHAR(55) NOT NULL,
        status TINYINT(4) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=INNODB;";

    $db->pdo->exec($SQL);
    }
    public function down(){
        $db = \app\core\Application::$app->db;
        $SQL = "DROP TABLE users";
        $db->pdo->exec($SQL);
    }
}