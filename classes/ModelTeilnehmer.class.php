<?php

if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

class ModelTeilnehmer {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function add($name, $firstname, $street, $housenumber, $zip, $city) {
        return $this->db->run('
          INSERT INTO teilnehmer (name, vorname, strassenname, hausnummer, postleitzahl, ort)
          VALUES (?, ?, ?, ?, ?, ?);
        ', [$name, $firstname, $street, $housenumber, $zip, $city])->rowCount();
    }

    public function update($name, $firstname, $street, $housenumber, $zip, $city, $updateId) {
        return $this->db->run('
            UPDATE teilnehmer
            SET name = ?, vorname = ?, strassenname = ?, hausnummer= ?, postleitzahl = ?, ort = ?
            WHERE teilnnr = ?
        ', [$name, $firstname, $street, $housenumber, $zip, $city, $updateId])->rowCount();
    }

    public function delete($id) {
        return $this->db->run('
          DELETE FROM teilnehmer WHERE teilnnr = ?;
        ', [$id])->rowCount();
    }

    public function get($id) {
        return $this->db->run('
          SELECT t.teilnnr, t.name, t.vorname, t.strassenname, t.hausnummer, t.postleitzahl, t.ort
          FROM teilnehmer as t
          WHERE teilnnr = ?
          LIMIT 1;
        ', [$id])->fetch();
    }

    public function getAll() {
        return $this->db->run('
            SELECT t.teilnnr, t.name, t.vorname, t.strassenname, t.hausnummer, t.postleitzahl, t.ort,
                   count(tkz.kursnr) as anzahl_kurse
            FROM teilnehmer AS t
            LEFT JOIN tkz on tkz.teilnnr = t.teilnnr
            GROUP BY t.teilnnr
            ORDER BY t.name, t.vorname, t.ort;
        ')->fetchAll();
    }

    public function getParticipantsOfCourse($course) {
        return $this->db->run('
          SELECT
            t.teilnnr, t.name, t.vorname, t.strassenname, t.hausnummer, t.postleitzahl, t.ort
            FROM teilnehmer AS t
            JOIN tkz AS tkz ON tkz.teilnnr = t.teilnnr
            JOIN kurs AS k ON tkz.kursnr = k.kursnr
            WHERE tkz.kursnr = ?
            ORDER BY t.name, t.vorname, t.ort;
        ', [$course])->fetchAll();
    }

    public function getNumberOfParticipantsOfCourse($course) {
        return $this->db->run('
            SELECT count(t.teilnnr) as teilnehmerzahl
            FROM teilnehmer AS t
            JOIN tkz AS tkz ON tkz.teilnnr = t.teilnnr
            JOIN kurs AS k ON tkz.kursnr = k.kursnr
            WHERE tkz.kursnr = ?
            GROUP BY tkz.kursnr;
        ', [$course]);
    }

}