<?php

if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

class ModelKurse {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function add($katalognummer, $title, $duration, $prerequisites, $idlocation) {
        return $this->db->run('
            INSERT INTO kurs (katalognummer, kurs, dauer, voraussetzungen, ortnr)
            VALUES (?, ?, ?, ?, ?);
        ', [$katalognummer, $title, $duration, $prerequisites, $idlocation])->rowCount();
    }

    public function update($katalognummer, $title, $duration, $prerequisites, $idlocation, $updateId) {
        return $this->db->run('
            UPDATE kurs 
            SET katalognummer = ?, kurs = ?, dauer = ?, voraussetzungen = ?, ortnr = ?
            WHERE kursnr = ?;
        ', [$katalognummer, $title, $duration, $prerequisites, $idlocation, $updateId])->rowCount();
    }

    public function delete($id) {
        return $this->db->run('
            DELETE FROM kurs WHERE kursnr = ?;
        ', [$id])->rowCount();
    }

    public function get($id) {
        return $this->db->run('
            SELECT k.kursnr, k.katalognummer, k.kurs, k.dauer, k.voraussetzungen, k.ortnr
            FROM kurs as k 
            WHERE kursnr = ?
            LIMIT 1;
        ', [$id])->fetch();
    }

    public function getAll() {
        return $this->db->run('
            SELECT
                k.kursnr, k.katalognummer, k.kurs, k.dauer, k.voraussetzungen,
                o.ort, o.schule,
                count(tkz.teilnnr) as `teilnehmerzahl`
            FROM kurs as k
            JOIN ort as o on k.ortnr = o.ortnr
            LEFT JOIN tkz on tkz.kursnr = k.kursnr
            GROUP BY k.kursnr
            ORDER BY k.kurs ASC;
        ');
    }

    public function getCoursesOfParticipant($participant) {
        return $this->db->run('
            SELECT
                k.kursnr, k.katalognummer, k.kurs, k.dauer, k.voraussetzungen,
                o.ort, o.schule
            FROM kurs as k
            JOIN ort as o on k.ortnr = o.ortnr
            LEFT JOIN tkz on tkz.kursnr = k.kursnr
            WHERE tkz.teilnnr = ?
            ORDER BY k.kurs ASC;
        ', [$participant]);
    }

    public function getMax($count = 12) {
        return $this->db->run('
            SELECT
                k.kursnr, k.katalognummer, k.kurs, k.dauer, k.voraussetzungen,
                o.ort, o.schule,
                count(tkz.teilnnr) as `Teilnehmerzahl`
            FROM kurs as k
            JOIN ort as o on k.ortnr = o.ortnr
            LEFT JOIN tkz on tkz.kursnr = k.kursnr
            GROUP BY k.kursnr
            ORDER BY k.kurs ASC
          LIMIT ?;
        ', [$count]);
    }

}