<?php

if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

class ModelBuchung {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        return $this->db->run('
            SELECT * FROM tkz
            JOIN teilnehmer t on tkz.teilnnr = t.teilnnr
            JOIN kurs k on tkz.kursnr = k.kursnr
            JOIN ort o on k.ortnr = o.ortnr
            ORDER BY t.name, t.vorname, t.wohnort;
        ');
    }

    public function add($course, $participant) {
        return $this->db->run('
          INSERT INTO tkz (teilnnr, kursnr) 
          VALUES (?, ?);
        ', [$participant, $course]);
    }

    public function delete($id) {
        return $this->db->run('
          DELETE FROM tkz WHERE id = ?;
        ', [$id])->rowCount();
    }

}