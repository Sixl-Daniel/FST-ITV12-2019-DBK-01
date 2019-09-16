<?php

if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

class ModelUser {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function add($userName, $firstName, $lastName, $email, $password, $salutation, $street, $streetNo, $zip, $city, $doiToken) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $this->db->run('
            INSERT INTO user (user_name, first_name, last_name, email, password, salutation, doi_token, street, street_no, zip, city)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
        ', [$userName, $firstName, $lastName, $email, $hashedPassword, $salutation, $doiToken, $street, $streetNo, $zip, $city])->rowCount();
    }

    public function isActivated($userName) {
        $user = $this->db->run('
            SELECT u.doi
            FROM user as u
            WHERE u.user_name = ?
            LIMIT 1
        ', [$userName])->fetch();
        if($user->doi == 1) return true;
        return false;
    }

    public function activate($userName, $doiToken) {
        return $this->db->run('
            UPDATE user 
            SET doi = 1
            WHERE user_name = ? AND doi_token = ?;
        ', [$userName, $doiToken])->rowCount();
    }

    public function get($userName, $enteredPassword) {
        $user = $this->db->run('
            SELECT u.id, u.user_name, u.first_name, u.last_name, u.email, u.password, u.salutation, u.role, u.created, u.modified, u.doi, u.street, u.street_no, u.zip, u.city
            FROM user as u
            WHERE u.user_name = ?
            LIMIT 1
        ', [$userName])->fetch();

        if(empty($user) || $user->doi != 1) return false;

        if(password_verify($enteredPassword, $user->password)) {
            unset($user->password);
            return $user;
        };

        return false;
    }



}