<?php

if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

class ModelOrt {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function add($city, $school) {
        return $this->db->run('
          INSERT INTO ort (ort, schule) 
          VALUES (?, ?);
        ', [$city, $school]);
    }

    public function delete($id) {
        return $this->db->run('
          DELETE FROM ort WHERE ortnr = ?;
        ', [$id])->rowCount();
    }

    public function getAll() {
        return $this->db->run('
            SELECT
                o.ortnr, o.ort, o.schule
            FROM ort as o
            ORDER BY o.ort ASC;
        ');
    }

}