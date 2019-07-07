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
        ', [$city, $school])->rowCount();
    }

    public function update($city, $school, $updateId) {
        return $this->db->run('
          UPDATE ort 
          SET ort = ?, schule = ? 
          WHERE  ortnr = ?;
        ', [$city, $school, $updateId])->rowCount();
    }

    public function delete($id) {
        return $this->db->run('
          DELETE FROM ort 
          WHERE ortnr = ?;
        ', [$id])->rowCount();
    }

    public function get($id) {
        return $this->db->run('
            SELECT
                o.ortnr, o.ort, o.schule
            FROM ort as o
            WHERE o.ortnr = ?
            LIMIT 1;
        ', [$id])->fetch();
    }

    public function getAll() {
        return $this->db->run('
            SELECT
                o.ortnr, o.ort, o.schule
            FROM ort as o
            ORDER BY o.schule ASC;
        ')->fetchAll();
    }

}