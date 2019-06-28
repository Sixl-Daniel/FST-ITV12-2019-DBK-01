<?php

if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

class Database {

    private $db;

    private $optionsPDO = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET lc_time_names='de_DE', NAMES utf8mb4"
    ];

    public function __construct(){
        $config = parse_ini_file(ROOT . "config/db.ini");
        $dsn = 'mysql:host='.$config['host'].';port='.$config['port'].';dbname='.$config['db'].';charset='.$config['charset'];
        try {
            $this->db = new PDO($dsn, $config['user'], $config['pass'], $this->optionsPDO);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    function run($sql, $params = NULL) {
        if(!$params)  return $this->db->query($sql);
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

}