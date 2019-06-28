jQuery(document).ready(function($){

    /* init ui */

    $('.sidenav').sidenav();
    $('#modal').modal();
    $('select').formSelect();
    $('.materialboxed').materialbox();

    /* alias */

    const l = console.log;

    /* swal */

    const note = Swal.mixin({
        confirmButtonColor: '#009688'
    });

    /* get token */

    const token = $('meta[name=csrf-token]').attr("content");

    /* general errors via modal - no AJAX */

    function showGeneralError(kind) {
        $errorHeading = "Fehler";
        $errorIcon = "error";
        switch (kind) {
            case 'getParticipants':
                note.fire($errorHeading, "Die Teilnehmerliste des Kurses konnte leider nicht geladen werden.", $errorIcon);
                break;

            case 'getCourses':
                note.fire($errorHeading, "Die Kursliste des Teilnehmers konnte leider nicht geladen werden.", $errorIcon);
                break;

            case 'addCourse':
                note.fire($errorHeading, "Der neue Kurs konnte leider nicht angelegt werden.", $errorIcon);
                break;

            case 'deleteCourse':
                note.fire($errorHeading, "Der Kurs konnte leider nicht gelöscht werden.", $errorIcon);
                break;

            case 'addBooking':
                note.fire($errorHeading, "Der Teilnehmer konnte leider nicht für den Kurs angemeldet werden.", $errorIcon);
                break;

            case 'deleteBooking':
                note.fire($errorHeading, "Der Teilnehmer konnte leider nicht von diesem Kurs abgemeldet werden.", $errorIcon);
                break;

            case 'addParticipant':
                note.fire($errorHeading, "Der neue Teilnehmer konnte leider nicht angelegt werden.", $errorIcon);
                break;

            case 'deleteParticipant':
                note.fire($errorHeading, "Der Teilnehmer konnte leider nicht gelöscht werden.", $errorIcon);
                break;

            case 'addLocation':
                note.fire($errorHeading, "Der neue Ort konnte leider nicht angelegt werden.", $errorIcon);
                break;

            case 'verifyLogin':
                note.fire($errorHeading, "Ihre Anmeldedaten konnten leider nicht überprüft werden.", $errorIcon);
                break;

            case 'deleteLocation':
                note.fire($errorHeading, "Der Ort konnte leider nicht gelöscht werden.", $errorIcon);
                break;

            default:
                note.fire($errorHeading, "Die Anfrage konnte leider nicht verarbeitet werden.", $errorIcon);
        };
        console.error("AJAX-Fehler // main.js");
    }

    /*
     * AJAX endpoint
     */

    const urlAjaXInternal = '/ajax/ajax.php';

    /*
     * course list : show participants in modal on button click
     */

    const listCourses = $("#list-courses");

    listCourses.on('click','.show-participants', function() {
        getParticipants($(this).data('course'));
    });

    function getParticipants(course) {
        // early return if no value provided
        if(!course) return;
        // get participants
        const data = {
            request: 'getParticipantsOfCourse',
            course: course,
            token: token
        };
        $.ajax({
            type: "POST",
            url: urlAjaXInternal,
            data: data
        })
            .done(function (results) {
                note.fire(results.heading, results.message, results.icon);
            })
            .fail(function (xhr) {
                showGeneralError('getParticipants');
            });
    }

    /*
     * course list : actions
     */

    /* delete course */

    listCourses.on('click', '.delete-course', function(event){
        deleteCourse($(this).data('course'));
    });

    function deleteCourse(course) {
        // check if all needed fields are there;
        if (! course) return;
        // if all fields filled delete location
        const data = {
            request: 'deleteCourse',
            token: token,
            course: course
        };
        $.ajax({
            type: "POST",
            url: urlAjaXInternal,
            data: data
        })
            .done(function(results) {
                // early return if status error / show custom error
                if(results.status == 'error') {
                    note.fire(results.heading, results.message, results.icon);
                    return;
                }
                // success: reset form and reload page to update selection fields
                if(results.status == 'success') {
                    note.fire(results.heading, results.message, results.icon)
                        .then(function(){
                            location.reload();
                        });
                }
            })
            .fail(function (xhr) {
                showGeneralError('deleteCourse');
            });
    }

    /*
     * participant list : show participants in modal on button click
     */

    const listParticipants = $("#list-participants");

    listParticipants.on('click', '.show-courses', function() {
        getCourses($(this).data('participant'));
    });

    function getCourses(participant) {
        // early return if no value provided
        if(!participant) return;
        // get participants
        const data = {
            request: 'getCoursesOfParticipant',
            token: token,
            participant: participant
        };
        $.ajax({
            type: "POST",
            url: urlAjaXInternal,
            data: data
        })
            .done(function (results) {
                note.fire(results.heading, results.message, results.icon);
            })
            .fail(function (xhr) {
                showGeneralError('getCourses');
            });
    }

    /*
     * participant list : actions
     */

    /* delete participant */

    listParticipants.on('click', '.delete-participant', function(event){
        deleteParticipant($(this).data('participant'));
    });

    function deleteParticipant(participant) {
        // check if all needed fields are there;
        if (! participant) return;
        // if all fields filled delete location
        const data = {
            request: 'deleteParticipant',
            token: token,
            participant: participant
        };
        $.ajax({
            type: "POST",
            url: urlAjaXInternal,
            data: data
        })
            .done(function(results) {
                // early return if status error / show custom error
                if(results.status == 'error') {
                    note.fire(results.heading, results.message, results.icon);
                    return;
                }
                // success: reset form and reload page to update selection fields
                if(results.status == 'success') {
                    note.fire(results.heading, results.message, results.icon)
                        .then(function(){
                            location.reload();
                        });
                }
            })
            .fail(function (xhr) {
                showGeneralError('deleteParticipant');
            });
    }

    /*
     * course booking / add participant to course
     */

    const formAddBooking = $("#add-participant-to-course");

    formAddBooking.on('submit', function(event){
        event.preventDefault();
        const course = $(this).find('select[name="course"]').val();
        const participant = $(this).find('select[name="participant"]').val();
        addBooking(course, participant);
    });

    function addBooking(course, participant) {
        // early return if not both values provided
        if(! course || ! participant) return;
        // add new booking
        const data = {
            request: 'addBooking',
            course: course,
            participant: participant,
            token: token
        };
        $.ajax({
            type: "POST",
            url: urlAjaXInternal,
            data: data
        })
            .done(function (results) {
                if(results.status == 'success') formAddBooking.trigger('reset');
                note.fire(results.heading, results.message, results.icon);
            })
            .fail(function (xhr) {
                showGeneralError('addBooking');
            });
    }

    /*
     * add new course
     */

    const formAddCourse = $("#add-course");

    formAddCourse.on('submit', function(event){
        event.preventDefault();
        // get fields
        const id = $(this).find('input[name="id"]').val();
        const title = $(this).find('input[name="title"]').val();
        const duration = $(this).find('input[name="duration"]').val();
        const prerequisites = $(this).find('input[name="prerequisites"]').val();
        const location = $(this).find('select[name="location"]').val();
        addCourse(id, title, duration, prerequisites, location);
    });

    function addCourse(id, title, duration, prerequisites, location) {
        // check if all needed fields are there;
        if( ! id || ! title || ! duration || ! prerequisites || ! location) return;
        // if all fields create new course
        const data = {
            request: 'addCourse',
            token: token,
            id: id,
            title: title,
            duration: duration,
            prerequisites: prerequisites,
            location: location
        };
        $.ajax({
            type: "POST",
            url: urlAjaXInternal,
            data: data
        })
            .done(function(results) {
                // early return if status error / show custom error
                if(results.status == 'error') {
                    note.fire(results.heading, results.message, results.icon);
                    return;
                }
                // success: reset form and reload page to update selection fields
                if(results.status == 'success') {
                    formAddCourse.trigger("reset");
                    note.fire(results.heading, results.message, results.icon)
                        .then(function(){
                            location.reload();
                        });
                }
            })
            .fail(function (xhr) {
                showGeneralError('addCourse');
            });
    }

    /*
     * bookings list : actions
     */

    const listBookings = $("#list-bookings");

    /* delete booking */

    listBookings.on('click', '.delete-booking', function(event){
        deleteBooking($(this).data('booking'));
    });

    function deleteBooking(booking) {
        // check if all needed fields are there;
        if (! booking) return;
        // if all fields filled delete location
        const data = {
            request: 'deleteBooking',
            token: token,
            booking: booking
        };
        $.ajax({
            type: "POST",
            url: urlAjaXInternal,
            data: data
        })
            .done(function(results) {
                // early return if status error / show custom error
                if(results.status == 'error') {
                    note.fire(results.heading, results.message, results.icon);
                    return;
                }
                // success: reset form and reload page to update selection fields
                if(results.status == 'success') {
                    note.fire(results.heading, results.message, results.icon)
                        .then(function(){
                            location.reload();
                        });
                }
            })
            .fail(function (xhr) {
                showGeneralError('deleteBooking');
            });
    }

    /*
     * add new participant
     */

    const formAddParticipant = $("#add-participant");

    formAddParticipant.on('submit', function(event){
        event.preventDefault();
        // get fields
        const fields = [];
        $(this).find("input").each(function(){
            fields[$(this).attr('name')] = $(this).val().trim();
        });
        addParticipant(fields);
    });

    function addParticipant(fields) {
        // check if all needed fields are there;
        if( ! fields['name'] || ! fields['firstname'] || ! fields['street'] || ! fields['housenumber'] || ! fields['zip'] || ! fields['city'] ) return;
        // if all fields create new participant
        const data = {
            request: 'addParticipant',
            token: token,
            name: fields['name'],
            firstname: fields['firstname'],
            street: fields['street'],
            housenumber: fields['housenumber'],
            zip: fields['zip'],
            city: fields['city']
        };
        $.ajax({
            type: "POST",
            url: urlAjaXInternal,
            data: data
        })
            .done(function(results) {
                // early return if status error / show custom error
                if(results.status == 'error') {
                    note.fire(results.heading, results.message, results.icon);
                    return;
                }
                // success: reset form and reload page to update selection fields
                if(results.status == 'success') {
                    formAddParticipant.trigger("reset");
                    note.fire(results.heading, results.message, results.icon)
                        .then(function(){
                            location.reload();
                        });
                }
            })
            .fail(function (xhr) {
                showGeneralError('addParticipant');
            });
    }

    /*
     * add new location
     */

    const formAddLocation = $("#add-location");

    formAddLocation.on('submit', function(event){
        event.preventDefault();
        // get fields
        const fields = [];
        $(this).find("input").each(function(){
            fields[$(this).attr('name')] = $(this).val().trim();
        });
        addLocation(fields);
    });

    function addLocation(fields) {
        // check if all needed fields are there;
        if( ! fields['city'] || ! fields['school']) return;
        // if all fields create location
        const data = {
            request: 'addLocation',
            token: token,
            city: fields['city'],
            school: fields['school'],
        };
        $.ajax({
            type: "POST",
            url: urlAjaXInternal,
            data: data
        })
            .done(function(results) {
                // early return if status error / show custom error
                if(results.status == 'error') {
                    note.fire(results.heading, results.message, results.icon);
                    return;
                }
                // success: reset form and reload page to update selection fields
                if(results.status == 'success') {
                    formAddLocation.trigger("reset");
                    note.fire(results.heading, results.message, results.icon)
                        .then(function(){
                            location.reload();
                        });
                }
            })
            .fail(function (xhr) {
                showGeneralError('addLocation');
            });
    }

    /*
     * login form
     */

    const formLogin = $("#login-form");

    formLogin.on('submit', function(event){
        event.preventDefault();
        // get fields
        const username = $(this).find('input[name="username"]').val();
        const password = $(this).find('input[name="password"]').val();
        verifyLogin(username, password);
    });

    function verifyLogin(username, password) {
        // check if all needed fields are there;
        if (! username || ! password) return;
        // if all fields login
        const data = {
            request: 'verifyLogin',
            token: token,
            username: username,
            password: password,
        };
        $.ajax({
            type: "POST",
            url: urlAjaXInternal,
            data: data
        })
            .done(function(results) {
                // early return if status error / show custom error
                if(results.status == 'error') {

                    note.fire(results.heading, results.message, results.icon);
                    return;
                }
                // success: reset form and reload page to update selection fields
                if(results.status == 'success') {
                    formLogin.trigger("reset");
                    note.fire(results.heading, results.message, results.icon)
                        .then(function(){
                            location.reload();
                        });
                }
            })
            .fail(function (xhr) {
                showGeneralError('verifyLogin');
            });
    }

    /*
     * location listing : actions
     */

    const listLocations = $("#list-locations");

    /* delete location */

    listLocations.on('click', '.delete-location', function(event){
        deleteLocation($(this).data('location'));
    });

    function deleteLocation(id) {
        // check if all needed fields are there;
        if (! id) return;
        // if all fields filled delete location
        const data = {
            request: 'deleteLocation',
            token: token,
            location: id
        };
        $.ajax({
            type: "POST",
            url: urlAjaXInternal,
            data: data
        })
            .done(function(results) {
                // early return if status error / show custom error
                if(results.status == 'error') {
                    note.fire(results.heading, results.message, results.icon);
                    return;
                }
                // success: reset form and reload page to update selection fields
                if(results.status == 'success') {
                    note.fire(results.heading, results.message, results.icon)
                        .then(function(){
                            location.reload();
                        });
                }
            })
            .fail(function (xhr) {
                showGeneralError('deleteLocation');
            });
    }

});
      