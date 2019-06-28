<?php

if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

class ModelTeilnehmer {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function add($name, $firstname, $street, $housenumber, $zip, $city) {
        $strasse = $street . " " . $housenumber;
        $wohnort = $zip . " " . $city;
        return $this->db->run('
          INSERT INTO teilnehmer (name, vorname, strasse, wohnort)
          VALUES (?, ?, ?, ?);
        ', [$name, $firstname, $strasse, $wohnort]);
    }

    public function delete($id) {
        return $this->db->run('
          DELETE FROM teilnehmer WHERE teilnnr = ?;
        ', [$id])->rowCount();
    }

    public function getAll() {
        return $this->db->run('
            SELECT t.teilnnr, t.name, t.vorname, t.strasse, t.wohnort, 
                   count(tkz.kursnr) as anzahl_kurse
            FROM teilnehmer AS t
            LEFT JOIN tkz on tkz.teilnnr = t.teilnnr
            GROUP BY t.teilnnr
            ORDER BY t.name, t.vorname, t.wohnort;
        ');
    }

    public function getParticipantsOfCourse($course) {
        return $this->db->run('
          SELECT
            t.teilnnr, t.name, t.vorname, t.strasse, t.wohnort 
            FROM teilnehmer AS t
            JOIN tkz AS tkz ON tkz.teilnnr = t.teilnnr
            JOIN kurs AS k ON tkz.kursnr = k.kursnr
            WHERE tkz.kursnr = ?
            ORDER BY t.name, t.vorname, t.wohnort;
        ', [$course]);
    }

    public function getNumberOfParticipantsOfCourse($course) {
        return $this->db->run('
          SELECT 
            count(t.teilnnr) FROM teilnehmer AS t
            JOIN tkz AS tkz ON tkz.teilnnr = t.teilnnr
            JOIN kurs AS k ON tkz.kursnr = k.kursnr
            WHERE tkz.kursnr = ?;
        ', [$course]);
    }

}