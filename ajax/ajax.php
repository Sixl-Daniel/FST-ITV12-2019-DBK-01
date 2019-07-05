<?php
define("ROOT", "../");
require_once ROOT . 'includes/_init.php';

if (
    !isset($_SESSION['token']) ||
    empty($_SESSION['token']) ||
    $_SESSION['token']!=$_POST['token']
) exit('<p style="color:crimson;font-weight: 700;">Der direkter Zugriff auf die AJAX-Schnittstelle ist nicht erlaubt.</p>');

/* request */

if(empty($_POST['request'])) return;

$request = Helper::escape($_POST['request']);

/* response */

$response = new ResponseJSON();

$response->status = "error";
$response->icon = "error";
$response->heading = "Fehler";

switch($request) {

    case 'getParticipantsOfCourse':

        if(empty($_POST['course'])) return;

        $course = Helper::escape($_POST['course']);

        try {

            $db = new Database();
            $participantsModel = new ModelTeilnehmer($db);
            $participants = $participantsModel->getParticipantsOfCourse($course);

            // create list of participants
            $buffer = '<ul class="collection">';
            foreach ($participants as $p) {
                $buffer .= "<li class='collection-item'><b>$p->name $p->vorname</b>, $p->strasse, $p->wohnort</li>";
            }
            $buffer .= '</ul>';

            // respond
            $response->status = "success";
            $response->icon = "info";
            $response->heading = "Teilnehmerliste Kurs $course";
            $response->message = $buffer;

        } catch (PDOException $e) {
            $response->message = "Die Teilnehmerliste für den Kurs $course konnte leider nicht geladen werden. ($e->getCode())";
            error_log($e);
        }

        break;

    case 'getCoursesOfParticipant':

        if(empty($_POST['participant'])) return;

        $participant = Helper::escape($_POST['participant']);

        try {

            $db = new Database();
            $coursesModel = new ModelKurse($db);
            $courses = $coursesModel->getCoursesOfParticipant($participant);

            // create list of courses
            $buffer = '<ul class="collection">';
            foreach ($courses as $c) {
                $wordingEvenings = $c->dauer > 1 ? "Abende" : "Abend";
                $buffer .= "<li class='collection-item'><b>$c->kurs</b> ($c->dauer $wordingEvenings)<br>Kursnummer: $c->kursnr<br>Ort: $c->schule, $c->ort</li>";
            }
            $buffer .= '</ul>';

            // respond
            $response->status = "success";
            $response->icon = "info";
            $response->heading = "Kursliste";
            $response->message = $buffer;

        } catch (PDOException $e) {
            $response->message = "Die Kursliste für den Teilnehmer konnte leider nicht geladen werden. ($e->getCode())";
            error_log($e);
        }

        break;

    case 'addCourse':

        if(empty($_POST['id']) || empty($_POST['title']) || empty($_POST['duration']) || empty($_POST['prerequisites'])  || empty($_POST['location'])) return;

        $id = Helper::escape($_POST['id']);
        $title = Helper::escape($_POST['title']);
        $duration = Helper::escape($_POST['duration']);
        $prerequisites = Helper::escape($_POST['prerequisites']);
        $location = Helper::escape($_POST['location']);

        try {
            $db = new Database();
            $course = new ModelKurse($db);
            $insert = $course->add($id, $title, $duration, $prerequisites, $location);
            $response->status = "success";
            $response->icon = "success";
            $response->heading = 'Kurs angelegt';
            $response->message = "Der neue Kurs <strong>„${title}“</strong> mit der ID <strong>${id}</strong> wurde hinzugefügt.";
        } catch(PDOException $e) {
            if ($e->getCode() == 23000) {
                $response->message = "Der Kurs kann leider nicht angelegt werden.<br>Ein Kurs mit der ID <strong>${id}</strong> existiert bereits.";
            } else {
                $response->message = "Der Kurs <strong>„${title}“</strong> mit der ID <strong>${id}</strong> konnte leider nicht angelegt werden. ";
            }
            error_log($e);
        }

        break;

    case 'deleteCourse':

        if(empty($_POST['course'])) return;
        $id = Helper::escape($_POST['course']);

        try {
            $db = new Database();
            $courseModel = new ModelKurse($db);
            if($courseModel->delete($id)) {
                $response->status = "success";
                $response->icon = "success";
                $response->heading = 'Kurs gelöscht';
                $response->message = "Der Kurs mit der Id $id wurde erfolgreich entfernt.";
            } else {
                throw new PDOException;
            }
        } catch(PDOException $e) {
            $response->message = "Der Kurs mit der Id $id konnte leider nicht gelöscht werden.";
            error_log($e);
        }

        break;

    case 'addBooking':

        $course = !empty($_POST['course']) ? Helper::escape($_POST['course']) : '';
        $participant = !empty($_POST['participant']) ? Helper::escape($_POST['participant']) : '';

        try {
            $db = new Database();
            $booking = new ModelBuchung($db);
            $booking->add($course, $participant);
            $response->status = "success";
            $response->icon = "success";
            $response->heading = 'Buchung erfolgreich';
            $response->message = "Teilnehmer <strong>$participant</strong> wurde für den Kurs <strong>$course</strong> eingeschrieben.";
        } catch(PDOException $e) {
            $response->message = "Teilnehmer <strong>$participant</strong> konnte leider nicht für den Kurs <strong>$course</strong> eingeschrieben.";
            error_log($e);
        }

        break;

    case 'deleteBooking':

        if(empty($_POST['booking'])) return;
        $id = Helper::escape($_POST['booking']);

        try {
            $db = new Database();
            $bookingModel = new ModelBuchung($db);
            if($bookingModel->delete($id)) {
                $response->status = "success";
                $response->icon = "success";
                $response->heading = 'Buchung gelöscht';
                $response->message = "Der Teilnehmer wurde erfolgreich abgemeldet.";
            } else {
                throw new PDOException;
            }
        } catch(PDOException $e) {
            $response->message = "Der Teilnehmer konnte leider nicht abgemeldet werden.";
            error_log($e);
        }

        break;

    case 'addParticipant':

        $name = !empty($_POST['name']) ? Helper::escape($_POST['name']) : '';
        $firstname = !empty($_POST['firstname']) ? Helper::escape($_POST['firstname']) : '';
        $street = !empty($_POST['street']) ? Helper::escape($_POST['street']) : '';
        $housenumber = !empty($_POST['housenumber']) ? Helper::escape($_POST['housenumber']) : '';
        $zip = !empty($_POST['zip']) ? Helper::escape($_POST['zip']) : '';
        $city = !empty($_POST['city']) ? Helper::escape($_POST['city']) : '';

        try {
            $db = new Database();
            $participant = new ModelTeilnehmer($db);
            $participant->add($name, $firstname, $street, $housenumber, $zip, $city);
            $response->status = "success";
            $response->icon = "success";
            $response->heading = 'Teilnehmer angelegt';
            $response->message = "Teilnehmer/in <b>$firstname $name</b> wurde erfolgreich hinzugefügt.";
        } catch(PDOException $e) {
            $response->message = "Teilnehmer/in <b>$firstname $name</b> konnte leider nicht angelegt werden.";
            error_log($e);
        }

        break;

    case 'deleteParticipant':

        if(empty($_POST['participant'])) return;
        $id = Helper::escape($_POST['participant']);

        try {
            $db = new Database();
            $participantModel = new ModelTeilnehmer($db);
            if($participantModel->delete($id)) {
                $response->status = "success";
                $response->icon = "success";
                $response->heading = 'Teilnehmer gelöscht';
                $response->message = "Der Teilnehmer mit der Id $id wurde erfolgreich entfernt.";
            } else {
                throw new PDOException;
            }
        } catch(PDOException $e) {
            $response->message = "Der Teilnehmer mit der Id $id konnte leider nicht gelöscht werden.";
            error_log($e);
        }

        break;

    case 'addLocation':

        if(empty($_POST['city']) || empty($_POST['school'])) return;

        $city = Helper::escape($_POST['city']);
        $school = Helper::escape($_POST['school']);

        try {
            $db = new Database();
            $location = new ModelOrt($db);
            $location->add($city, $school);
            $response->status = "success";
            $response->icon = "success";
            $response->heading = 'Ort angelegt';
            $response->message = "<b>$school</b> in <b>$city</b> wurde hinzugefügt.";
        } catch(PDOException $e) {
            $response->message = "<b>$school</b> in <b>$city</b> konnte leider nicht angelegt werden.";
            error_log($e);
        }

        break;

    case 'deleteLocation':

        if(empty($_POST['location'])) return;
        $id = Helper::escape($_POST['location']);

        try {
            $db = new Database();
            $location = new ModelOrt($db);
            // $del = $location->delete($id);
            if($location->delete($id)) {
                $response->status = "success";
                $response->icon = "success";
                $response->heading = 'Ort gelöscht';
                $response->message = "Der Ort mit der Id $id wurde erfolgreich entfernt.";
            } else {
                throw new PDOException;
            }
        } catch(PDOException $e) {
            $response->message = "Der Ort mit der Id $id konnte leider nicht gelöscht werden.";
            error_log($e);
        }

        break;

    case 'verifyLogin':

        if(empty($_POST['username']) || empty($_POST['password'])) throw new Exception('Username und Passwort dürfen nicht leer sein.');

        $enteredUsername = Helper::escape($_POST['username']);
        $enteredPassword = Helper::escape($_POST['password']);

        $users = parse_ini_file(ROOT . "config/users.ini", true);
        $dbPassword = $users[$enteredUsername]['password'];

        if($dbPassword == $enteredPassword) {

            // write data to session
            $_SESSION['login'] = $users[$enteredUsername];
            $timestamp = time();
            $_SESSION['login']['timestamp'] = $timestamp;
            $_SESSION['login']['time'] = strftime("%A, %d. %B %Y, %H:%M Uhr", $timestamp);

            $loggedIn = true;
            $response->status = "success";
            $response->icon = "success";
            $response->heading = 'Login';
            $response->message = "Sie wurden erfolgreich eingeloggt.";
        } else {
            $response->message = "Diese Kombination aus Nutzername und Passwort existiert leider nicht. Bitte kontrollieren Sie ihre Zugangsdaten.";
        }


        break;

    default:

        $response->message = "Kein valider Request-Typ.";

        break;

}

// provide JSON

header('Content-type:application/json;charset=utf-8');
header('Status: 200');
echo  json_encode($response);
