<?php
define("ROOT", "../");
require_once ROOT . 'includes/_init.php';

if (
    !isset($_SESSION['token']) ||
    empty($_SESSION['token']) ||
    $_SESSION['token']!=$_POST['token']
) exit('<p style="color:crimson;font-weight: 700;">Der direkte Zugriff auf die AJAX-Schnittstelle ist nicht erlaubt.</p>');

/* request */

if(empty($_POST['request'])) return;

$request = Helper::escape($_POST['request']);

/* response */

$response = new ResponseJSON();

$response->status = "error";
$response->icon = "error";
$response->heading = "Serverseitiger Fehler";

switch($request) {

    /*
     * COURSES
     ******************************************************************/

    case 'getCoursesOfParticipant':

        if(empty($_POST['participant'])) return;

        $participantId = Helper::escape($_POST['participant']);

        try {
            $db = new Database();

            $coursesModel = new ModelKurse($db);
            $courses = $coursesModel->getCoursesOfParticipant($participantId);

            $participantsModel = new ModelTeilnehmer($db);
            $participant = $participantsModel->get($participantId);

            if(!empty($courses) && !empty($participant)) {
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
                $response->heading = "Kursliste<br>$participant->vorname $participant->name";
                $response->message = $buffer;
            } else {
                throw new PDOException;
            }
        } catch (PDOException $e) {
            $response->message = "Die Kursliste für den Teilnehmer konnte leider nicht geladen werden. ($e->getCode())";
            error_log($e);
        }

        break;

    case 'addCourse':

        if(empty($_POST['catalogId']) || empty($_POST['title']) || empty($_POST['duration']) || empty($_POST['prerequisites'])  || empty($_POST['location'])) return;

        $catalogId = Helper::escape($_POST['catalogId']);
        $title = Helper::escape($_POST['title']);
        $duration = Helper::escape($_POST['duration']);
        $prerequisites = Helper::escape($_POST['prerequisites']);
        $location = Helper::escape($_POST['location']);

        try {
            $db = new Database();
            $courseModel = new ModelKurse($db);
            $insert = $courseModel->add($catalogId, $title, $duration, $prerequisites, $location);
            if(!empty($insert)) {
                // respond
                $response->status = "success";
                $response->icon = "success";
                $response->heading = 'Kurs angelegt';
                $response->message = "Der neue Kurs <strong>$title</strong> mit der Nummer <strong>$catalogId</strong> wurde hinzugefügt.";
            } else {
                throw new PDOException;
            }
        } catch(PDOException $e) {

            if ($e->getCode() == 23000) {
                $response->message = "Der Kurs <strong>$title</strong> kann leider nicht angelegt werden.<br>Ein Kurs mit der Nummer <strong>$catalogId</strong> existiert bereits. Die Nummer muss eindeutig sein.";
            } else {
                $response->message = "Der Kurs <strong>$title</strong> mit der Nummer <strong>$catalogId</strong> konnte leider nicht angelegt werden. ";
            }
            error_log($e);
        }

        break;

    case 'updateCourse':

        if(empty($_POST['catalogId']) || empty($_POST['title']) || empty($_POST['duration']) || empty($_POST['prerequisites'])  || empty($_POST['location']) || empty($_POST['id'])) return;

        $catalogId = Helper::escape($_POST['catalogId']);
        $title = Helper::escape($_POST['title']);
        $duration = Helper::escape($_POST['duration']);
        $prerequisites = Helper::escape($_POST['prerequisites']);
        $location = Helper::escape($_POST['location']);
        $updateId = Helper::escape($_POST['id']);

        try {
            $db = new Database();
            $courseModel = new ModelKurse($db);

            $update = $courseModel->update($catalogId, $title, $duration, $prerequisites, $location, $updateId);

            if(!empty($update)) {
                // respond
                $response->status = "success";
                $response->icon = "success";
                $response->heading = 'Kurs geändert';
                $response->message = "Der Kurs wurde erfolgreich aktualisiert.";
            } else {
                throw new PDOException;
            }
        } catch(PDOException $e) {
            $response->message = "Der Kurs konnte leider nicht aktualisiert werden.";
            error_log($e);
        }

        break;

    case 'deleteCourse':

        if(empty($_POST['course'])) return;
        $id = Helper::escape($_POST['course']);

        try {
            $db = new Database();
            $courseModel = new ModelKurse($db);
            $delete = $courseModel->delete($id);
            if(!empty($delete)) {
                // respond
                $response->status = "success";
                $response->icon = "success";
                $response->heading = 'Kurs gelöscht';
                $response->message = "Der Kurs wurde erfolgreich entfernt.";
            } else {
                throw new PDOException;
            }
        } catch(PDOException $e) {
            $response->message = "Der Kurs konnte leider nicht gelöscht werden.";
            error_log($e);
        }

        break;

    /*
     * BOOKINGS
     ******************************************************************/

    case 'addBooking':

        $course = !empty($_POST['course']) ? Helper::escape($_POST['course']) : '';
        $participant = !empty($_POST['participant']) ? Helper::escape($_POST['participant']) : '';

        try {
            $db = new Database();
            $bookingModel = new ModelBuchung($db);
            $insert = $bookingModel->add($course, $participant);
            if(!empty($insert)) {
                // respond
                $response->status = "success";
                $response->icon = "success";
                $response->heading = 'Buchung erfolgreich';
                $response->message = "Teilnehmer <strong>$participant</strong> wurde für den Kurs <strong>$course</strong> eingeschrieben.";
            } else {
                throw new PDOException;
            }

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
            $deletion = $bookingModel->delete($id);
            if(!empty($deletion)) {
                // respond
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

    /*
     * PARTICIPANTS
     ******************************************************************/

    case 'getParticipantsOfCourse':

        if(empty($_POST['course'])) return;

        $courseId = Helper::escape($_POST['course']);

        try {
            $db = new Database();

            $participantsModel = new ModelTeilnehmer($db);
            $participants = $participantsModel->getParticipantsOfCourse($courseId);

            $courseModel = new ModelKurse($db);
            $course = $courseModel->get($courseId);

            if(!empty($participants) && !empty($course)) {
                // create list of participants
                $buffer = '<ul class="collection">';
                foreach ($participants as $p) {
                    $buffer .= "<li class='collection-item'><b>$p->name $p->vorname</b>, $p->strassenname $p->hausnummer, $p->postleitzahl $p->ort</li>";
                }
                $buffer .= '</ul>';
                // respond
                $response->status = "success";
                $response->icon = "info";
                $response->heading = "Teilnehmerliste<br>$course->kurs";
                $response->message = $buffer;
            } else {
                throw new PDOException;
            }
        } catch (PDOException $e) {
            $response->message = "Die Teilnehmerliste für den Kurs $courseId konnte leider nicht geladen werden. ($e->getCode())";
            error_log($e);
        }

        break;

    case 'addParticipant':

        if(empty($_POST['name']) || empty($_POST['firstname']) || empty($_POST['street']) || empty($_POST['housenumber']) || empty($_POST['zip']) || empty($_POST['city'])) return;

        $name = Helper::escape($_POST['name']);
        $firstname = Helper::escape($_POST['firstname']);
        $street = Helper::escape($_POST['street']);
        $housenumber = Helper::escape($_POST['housenumber']);
        $zip = Helper::escape($_POST['zip']);
        $city = Helper::escape($_POST['city']);

        try {
            $db = new Database();
            $participantModel = new ModelTeilnehmer($db);
            $insert = $participantModel->add($name, $firstname, $street, $housenumber, $zip, $city);
            if(!empty($insert)) {
                // respond
                $response->status = "success";
                $response->icon = "success";
                $response->heading = 'Teilnehmer angelegt';
                $response->message = "Teilnehmer/in <b>$firstname $name</b> wurde erfolgreich hinzugefügt.";
            } else {
                throw new PDOException;
            }
        } catch(PDOException $e) {
            $response->message = "Teilnehmer/in <b>$firstname $name</b> konnte leider nicht angelegt werden.";
            error_log($e);
        }

        break;

    case 'updateParticipant':

        if(empty($_POST['name']) || empty($_POST['firstname']) || empty($_POST['street']) || empty($_POST['housenumber']) || empty($_POST['zip']) || empty($_POST['city']) || empty($_POST['id'])) return;

        $name = Helper::escape($_POST['name']);
        $firstname = Helper::escape($_POST['firstname']);
        $street = Helper::escape($_POST['street']);
        $housenumber = Helper::escape($_POST['housenumber']);
        $zip = Helper::escape($_POST['zip']);
        $city = Helper::escape($_POST['city']);
        $updateId = Helper::escape($_POST['id']);

        try {
            $db = new Database();
            $participantModel = new ModelTeilnehmer($db);
            $update = $participantModel->update($name, $firstname, $street, $housenumber, $zip, $city, $updateId);
            if(!empty($update)) {
                // respond
                $response->status = "success";
                $response->icon = "success";
                $response->heading = 'Teilnehmer geändert';
                $response->message = "Der Teilnehmer wurde erfolgreich aktualisiert.";
            } else {
                throw new PDOException;
            }
        } catch(PDOException $e) {
            $response->message = "Der Teilnehmer konnte leider nicht aktualisiert werden.";
            error_log($e);
        }

        break;

    case 'deleteParticipant':

        if(empty($_POST['participant'])) return;
        $id = Helper::escape($_POST['participant']);

        try {
            $db = new Database();
            $participantModel = new ModelTeilnehmer($db);
            $deletion = $participantModel->delete($id);
            if(!empty($deletion)) {
                // respond
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

    /*
     * LOCATIONS
     ******************************************************************/

    case 'addLocation':

    if(empty($_POST['city']) || empty($_POST['school'])) return;

    $city = Helper::escape($_POST['city']);
    $school = Helper::escape($_POST['school']);

    try {
        $db = new Database();
        $location = new ModelOrt($db);
        $insert = $location->add($city, $school);
        if(!empty($insert)) {
            // respond
            $status = 200;
            $response->status = "success";
            $response->icon = "success";
            $response->heading = 'Ort angelegt';
            $response->message = "<b>$school</b> in <b>$city</b> wurde hinzugefügt.";
        } else {
            throw new PDOException;
        }
    } catch(PDOException $e) {
        $response->message = "<b>$school</b> in <b>$city</b> konnte leider nicht angelegt werden.";
        error_log($e);
    }

    break;

    case 'updateLocation':

        if(empty($_POST['id']) || empty($_POST['city']) || empty($_POST['school'])) return;

        $id = Helper::escape($_POST['id']);
        $city = Helper::escape($_POST['city']);
        $school = Helper::escape($_POST['school']);

        try {
            $db = new Database();
            $location = new ModelOrt($db);
            $update = $location->update($city, $school, $id);
            if(!empty($update)) {
                // respond
                $status = 200;
                $response->status = "success";
                $response->icon = "success";
                $response->heading = 'Ort aktualisiert';
                $response->message = "Die Location wurde erfolgreich auf <b>$school</b> in <b>$city</b> geändert.";
            } else {
                throw new PDOException;
            }

        } catch(PDOException $e) {
            $response->message = "Der Ort konnte leider nicht aktualisiert werden.";
            error_log($e);
        }

        break;

    case 'deleteLocation':

        if(empty($_POST['location'])) return;
        $id = Helper::escape($_POST['location']);

        try {
            $db = new Database();
            $location = new ModelOrt($db);
            $deletion = $location->delete($id);
            if(!empty($deletion)) {
                // respond
                $status = 200;
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

    /*
     * LOGIN
     ******************************************************************/

    case 'verifyLogin':

        if(empty($_POST['username']) || empty($_POST['password'])) return;

        $enteredUsername = Helper::escape($_POST['username']);
        $enteredPassword = Helper::escape($_POST['password']);

        try {
            $db = new Database();
            $userModel = new ModelUser($db);

            $user = $userModel->verify($enteredUsername, $enteredPassword);

            if(!empty($user)) {

                // set time
                $timestamp = time();
                $timeformat = "%A, %d. %B %Y, %H:%M Uhr";
                $timeformatShort = "%d.%m.%Y, %H:%M Uhr";

                // write data to session
                $_SESSION['login']['user_name'] = $user->user_name;
                $_SESSION['login']['first_name'] = $user->first_name;
                $_SESSION['login']['last_name'] = $user->last_name;
                $_SESSION['login']['email'] = $user->email;
                $_SESSION['login']['salutation'] = $user->salutation;
                $_SESSION['login']['role'] = $user->role;
                $_SESSION['login']['timestamp'] = $timestamp;
                $_SESSION['login']['time'] = strftime($timeformat, $timestamp);
                $_SESSION['login']['user_created'] = strftime($timeformatShort, strtotime($user->created));
                $_SESSION['login']['user_modified'] = strftime($timeformatShort, strtotime($user->modified));

                // respond
                $response->status = "success";
                $response->icon = "success";
                $response->heading = 'Login';
                $response->message = "Sie wurden erfolgreich eingeloggt.";
            } else {
                $response->heading = 'Ungültige Zugangsdaten';
                $response->message = "Diese Kombination aus Nutzername und Passwort existiert leider nicht. Bitte kontrollieren Sie Ihre Eingaben.";
            }

        } catch(PDOException $e) {
            $response->message = "Sie konnten leider nicht eingeloggt werden.";
            error_log($e);
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
