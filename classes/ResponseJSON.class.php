<?php

if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

class ResponseJSON {

    public $status;
    public $message;
    public $heading;
    public $data;
    public $errors;
    public $timestamp;

    public function __construct()
    {
        $this->status = "error";
        $this->icon = "error"; // success, error, warning, info, question
        $this->heading = "Fehler";
        $this->message = "Ein unbestimmter Fehler ist aufgetreten.";
        $this->data = []; // wird momentan nicht verwendet
        $this->errors = []; // wird momentan nicht verwendet
        $this->timestamp = date('Y-m-d H:i:s', time());
    }


}