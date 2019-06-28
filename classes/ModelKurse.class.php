<?php

if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

class ModelKurse {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function add($id, $title, $duration, $prerequisites, $idlocation) {
        return $this->db->run('
          INSERT INTO kurs (kursnr, kurs, dauer, voraussetzungen, ortnr)
          VALUES (?, ?, ?, ?, ?);
        ', [$id, $title, $duration, $prerequisites, $idlocation]);
    }

    public function delete($id) {
        return $this->db->run('
          DELETE FROM kurs WHERE kursnr = ?;
        ', [$id])->rowCount();
    }

    public function getAll() {
        return $this->db->run('
            SELECT
                k.kursnr, k.kurs, k.dauer, k.voraussetzungen,
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
                k.kursnr, k.kurs, k.dauer, k.voraussetzungen,
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
                k.kursnr, k.kurs, k.dauer, k.voraussetzungen,
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