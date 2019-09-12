<?php

if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

class ModelUser {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function verify($userName, $enteredPassword) {
        $user = $this->db->run('
            SELECT u.id, u.user_name, u.first_name, u.last_name, u.email, u.password, u.salutation, u.role, u.created, u.modified 
            FROM user as u
            WHERE u.user_name = ?
            LIMIT 1
        ', [$userName])->fetch();

        if(!empty($user)) {
            $hashedPassword = $user->password;
            if(password_verify($enteredPassword, $hashedPassword)) {
                unset($user->password);
                return $user;
            };
        };

        return false;
    }



}