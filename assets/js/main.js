jQuery(document).ready(function ($) {

    /* init ui */

    $('.sidenav').sidenav();
    $('#modal').modal();
    $('select').formSelect();
    $('.materialboxed').materialbox();

    /* colors */

    const colors = {
        primary: '#009688'
    }

    /* alias */

    const l = console.log;

    /* swal */

    const note = Swal.mixin({
        confirmButtonColor: colors.primary,
        customClass: {
            container: 'container-class container-class--standard-note',
        }
    });

    const noteFull = Swal.mixin({
        grow: 'fullscreen',
        confirmButtonColor: colors.primary,
        customClass: {
            container: 'container-class container-class--fullscreen-note',
        }
    });

    function notify(results) {
        note.fire({
            title: results.heading,
            html: results.message,
            type: results.icon
        });
    }

    function notifyThenReload(results) {
        note.fire({
            title: results.heading,
            html: results.message,
            type: results.icon
        }).then(function () {
            location.reload();
        });
    }

    function notifyThenRedirect(results, url) {
        note.fire({
            title: results.heading,
            html: results.message,
            type: results.icon
        }).then(function () {
            location.replace(url);
        });
    }

    /* get token */

    const token = $('meta[name=csrf-token]').attr("content");

    /* general errors via modal - no AJAX */

    function showGeneralError(kind) {

        $errorHeading = "AJAX-Fehler";
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

            case 'updateCourse':
                note.fire($errorHeading, "Der Kurs konnte leider nicht aktualisiert werden.", $errorIcon);
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

            case 'updateParticipant':
                note.fire($errorHeading, "Der Teilnehmer konnte leider nicht aktualisiert werden.", $errorIcon);
                break;

            case 'deleteParticipant':
                note.fire($errorHeading, "Der Teilnehmer konnte leider nicht gelöscht werden.", $errorIcon);
                break;

            case 'addLocation':
                note.fire($errorHeading, "Der neue Ort konnte leider nicht angelegt werden.", $errorIcon);
                break;

            case 'deleteLocation':
                note.fire($errorHeading, "Der Ort konnte leider nicht gelöscht werden.", $errorIcon);
                break;

            case 'updateLocation':
                note.fire($errorHeading, "Der Ort konnte leider nicht aktualisiert werden.", $errorIcon);
                break;

            case 'verifyLogin':
                note.fire($errorHeading, "Ihre Anmeldedaten konnten leider nicht überprüft werden.", $errorIcon);
                break;

            case 'registerNewUser':
                note.fire($errorHeading, "Der neue Nutzer konnte leider nicht angelegt werden.", $errorIcon);
                break;

            default:
                note.fire($errorHeading, "Die Anfrage konnte leider nicht verarbeitet werden.", $errorIcon);
        }
    }

    /*
     * AJAX endpoint
     */

    const urlAjaXInternal = '/ajax/ajax.php';

    /*
     * COURSES
     *********************************************/

    const listCourses = $("#list-courses");

    const formAddCourse = $("#add-course");

    const formUpdateCourse = $("#edit-course");

    /*
     * course list : show participants in modal on button click
     */

    listCourses.on('click', '.show-participants', function () {
        getParticipants($(this).data('course'));
    });

    function getParticipants(course) {
        // early return if no value provided
        if (!course) return;
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
                notify(results);
            })
            .fail(function (xhr) {
                showGeneralError('getParticipants');
            });
    }

    /*
     * course edit-form : update course
     */

    formUpdateCourse.on('submit', function (event) {
        event.preventDefault();
        // get fields
        const id = $(this).data('course');
        const catalogId = $(this).find('input[name="catalog-id"]').val();
        const title = $(this).find('input[name="title"]').val();
        const duration = $(this).find('input[name="duration"]').val();
        const prerequisites = $(this).find('input[name="prerequisites"]').val();
        const location = $(this).find('select[name="location"]').val();
        updateCourse(id, catalogId, title, duration, prerequisites, location);
    });

    function updateCourse(id, catalogId, title, duration, prerequisites, location) {
        // check if all needed fields are there;
        if (!id || ! catalogId || !title || !duration || !prerequisites || !location) return;
        // if all fields create new course
        const data = {
            request: 'updateCourse',
            token: token,
            catalogId: catalogId,
            title: title,
            duration: duration,
            prerequisites: prerequisites,
            location: location,
            id: id
        };
        $.ajax({
            type: "POST",
            url: urlAjaXInternal,
            data: data
        })
            .done(function (results) {
                // early return if status error / show custom error
                if (results.status == 'error') {
                    notify(results);
                    return;
                }
                // success: reset form and reload page to update selection fields
                if (results.status == 'success') {
                    notifyThenRedirect(results, '/kurse');
                }
            })
            .fail(function () {
                showGeneralError('updateCourse');
            });
    }

    /*
     * course add-form : add new course
     */

    formAddCourse.on('submit', function (event) {
        event.preventDefault();
        // get fields
        const catalogId = $(this).find('input[name="catalog-id"]').val();
        const title = $(this).find('input[name="title"]').val();
        const duration = $(this).find('input[name="duration"]').val();
        const prerequisites = $(this).find('input[name="prerequisites"]').val();
        const location = $(this).find('select[name="location"]').val();
        addCourse(catalogId, title, duration, prerequisites, location);
    });

    function addCourse(catalogId, title, duration, prerequisites, location) {
        // check if all needed fields are there;
        if (!catalogId || !title || !duration || !prerequisites || !location) return;
        // if all fields create new course
        const data = {
            request: 'addCourse',
            token: token,
            catalogId: catalogId,
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
            .done(function (results) {
                // early return if status error / show custom error
                if (results.status == 'error') {
                    notify(results);
                    return;
                }
                // success: reset form and reload page to update selection fields
                if (results.status == 'success') {
                    notifyThenReload(results);
                }
            })
            .fail(function (xhr) {
                showGeneralError('addCourse');
            });
    }

    /*
     * course list : action delete course
     */

    listCourses.on('click', '.delete-course', function (event) {
        deleteCourse($(this).data('course'));
    });

    function deleteCourse(course) {
        // check if all needed fields are there;
        if (!course) return;
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
            .done(function (results) {
                // early return if status error / show custom error
                if (results.status == 'error') {
                    notify(results);
                    return;
                }
                // success: reset form and reload page to update selection fields
                if (results.status == 'success') {
                    notifyThenReload(results);
                }
            })
            .fail(function (xhr) {
                showGeneralError('deleteCourse');
            });
    }

    /*
     * PARTICIPANTS
     *********************************************/

    const listParticipants = $("#list-participants");

    const formAddParticipant = $("#add-participant");

    const formUpdateParticipant = $("#edit-participant");

    /*
     * participant list : show participants in modal on button click
     */

    listParticipants.on('click', '.show-courses', function () {
        getCourses($(this).data('participant'));
    });

    function getCourses(participant) {
        // early return if no value provided
        if (!participant) return;
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
                notify(results);
            })
            .fail(function (xhr) {
                showGeneralError('getCourses');
            });
    }

    /*
     * participant edit-form : update participant
     */

    formUpdateParticipant.on('submit', function (event) {
        event.preventDefault();
        // get fields
        const fields = [];
        $(this).find("input").each(function () {
            fields[$(this).attr('name')] = $(this).val().trim();
        });
        // get rendered id
        fields['id'] = $(this).data('participant');
        updateParticipant(fields);
    });

    function updateParticipant(fields) {
        // check if all needed fields are there;
        if (!fields['id'] || !fields['name'] || !fields['firstname'] || !fields['street'] || !fields['housenumber'] || !fields['zip'] || !fields['city']) return;
        // if all fields create new participant
        const data = {
            request: 'updateParticipant',
            token: token,
            name: fields['name'],
            firstname: fields['firstname'],
            street: fields['street'],
            housenumber: fields['housenumber'],
            zip: fields['zip'],
            city: fields['city'],
            id: fields['id']
        };
        $.ajax({
            type: "POST",
            url: urlAjaXInternal,
            data: data
        })
            .done(function (results) {
                // early return if status error / show custom error
                if (results.status == 'error') {
                    notify(results);
                    return;
                }
                // success: reset form and reload page to update selection fields
                if (results.status == 'success') {
                    notifyThenRedirect(results, '/teilnehmer');
                }
            })
            .fail(function (xhr) {
                showGeneralError('updateParticipant');
            });
    }

    /*
     * participant list : action delete participant
     */

    listParticipants.on('click', '.delete-participant', function (event) {
        deleteParticipant($(this).data('participant'));
    });

    function deleteParticipant(participant) {
        // check if all needed fields are there;
        if (!participant) return;
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
            .done(function (results) {
                // early return if status error / show custom error
                if (results.status == 'error') {
                    notify(results);
                    return;
                }
                // success: reset form and reload page to update selection fields
                if (results.status == 'success') {
                    notifyThenReload(results);
                }
            })
            .fail(function (xhr) {
                showGeneralError('deleteParticipant');
            });
    }

    /*
     * participant add-form : add new participant
     */

    formAddParticipant.on('submit', function (event) {
        event.preventDefault();
        // get fields
        const fields = [];
        $(this).find("input").each(function () {
            fields[$(this).attr('name')] = $(this).val().trim();
        });
        addParticipant(fields);
    });

    function addParticipant(fields) {
        // check if all needed fields are there;
        if (!fields['name'] || !fields['firstname'] || !fields['street'] || !fields['housenumber'] || !fields['zip'] || !fields['city']) return;
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
            .done(function (results) {
                // early return if status error / show custom error
                if (results.status == 'error') {
                    notify(results);
                    return;
                }
                // success: reset form and reload page to update selection fields
                if (results.status == 'success') {
                    notifyThenReload(results);
                }
            })
            .fail(function (xhr) {
                showGeneralError('addParticipant');
            });
    }

    /*
     * BOOKINGS
     *********************************************/

    const listBookings = $("#list-bookings");

    const formAddBooking = $("#add-participant-to-course");

    /*
     * bookings list : action delete booking
     */

    listBookings.on('click', '.delete-booking', function (event) {
        deleteBooking($(this).data('booking'));
    });

    function deleteBooking(booking) {
        // check if all needed fields are there;
        if (!booking) return;
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
            .done(function (results) {
                // early return if status error / show custom error
                if (results.status == 'error') {
                    notify(results);
                    return;
                }
                // success: reset form and reload page to update selection fields
                if (results.status == 'success') {
                    notifyThenReload(results);
                }
            })
            .fail(function (xhr) {
                showGeneralError('deleteBooking');
            });
    }

    /*
     * booking add-form : add booking (add participant to course)
     */

    formAddBooking.on('submit', function (event) {
        event.preventDefault();
        const course = $(this).find('select[name="course"]').val();
        const participant = $(this).find('select[name="participant"]').val();
        addBooking(course, participant);
    });

    function addBooking(course, participant) {
        // early return if not both values provided
        if (!course || !participant) return;
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
                if (results.status == 'success') formAddBooking.trigger('reset');
                notify(results);
            })
            .fail(function (xhr) {
                showGeneralError('addBooking');
            });
    }

    /*
     * LOCATIONS
     *********************************************/

    const listLocations = $("#list-locations");

    const formAddLocation = $("#add-location");

    const formUpdateLocation = $("#edit-location");

    /*
     * location add-form : add new location
     */

    formAddLocation.on('submit', function (event) {
        event.preventDefault();
        // get fields
        const fields = [];
        $(this).find("input").each(function () {
            fields[$(this).attr('name')] = $(this).val().trim();
        });
        addLocation(fields);
    });

    function addLocation(fields) {
        // check if all needed fields are there;
        if (!fields['city'] || !fields['school']) return;
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
            .done(function (results) {
                // early return if status error / show custom error
                if (results.status == 'error') {
                    notify(results);
                    return;
                }
                // success: reset form and reload page to update selection fields
                if (results.status == 'success') {
                    notifyThenReload(results);
                }
            })
            .fail(function (xhr) {
                showGeneralError('addLocation');
            });
    }

    /*
     * location edit-form : update location
     */

    formUpdateLocation.on('submit', function (event) {
        event.preventDefault();
        // get fields
        const fields = [];
        $(this).find("input").each(function () {
            fields[$(this).attr('name')] = $(this).val().trim();
        });
        // get rendered id
        fields['id'] = $(this).data('location');
        updateLocation(fields);
    });

    function updateLocation(fields) {
        // check if all needed fields are there;
        if (!fields['id'] || !fields['city'] || !fields['school']) return;
        // if all fields create location
        const data = {
            request: 'updateLocation',
            token: token,
            id: fields['id'],
            city: fields['city'],
            school: fields['school'],
        };
        $.ajax({
            type: "POST",
            url: urlAjaXInternal,
            data: data
        })
            .done(function (results) {
                // early return if status error / show custom error
                if (results.status == 'error') {
                    notify(results);
                    return;
                }
                // success: reset form and reload page to update selection fields
                if (results.status == 'success') {
                    notifyThenRedirect(results, '/orte');
                    return;
                }
            })
            .fail(function (xhr) {
                showGeneralError('updateLocation');
            });
    }

    /*
     * location listing : action delete location
     */

    listLocations.on('click', '.delete-location', function (event) {
        deleteLocation($(this).data('location'));
    });

    function deleteLocation(id) {
        // check if all needed fields are there;
        if (!id) return;
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
            .done(function (results) {
                // early return if status error / show custom error
                if (results.status == 'error') {
                    notify(results);
                    return;
                }
                // success: reset form and reload page to update selection fields
                if (results.status == 'success') {
                    notifyThenReload(results);
                }
            })
            .fail(function (xhr) {
                showGeneralError('deleteLocation');
            });
    }

    /*
     * LOGIN
     *********************************************/

    const formLogin = $("#login-form");

    formLogin.on('submit', function (event) {
        event.preventDefault();
        // get fields
        const username = $(this).find('input[name="username"]').val();
        const password = $(this).find('input[name="password"]').val();
        verifyLogin(username, password);
    });

    function verifyLogin(username, password) {
        // check if all needed fields are there;
        if (!username || !password) return;
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
            .done(function (results) {
                // early return if status error / show custom error
                if (results.status == 'error') {
                    notify(results);
                    return;
                }
                // success: reset form and reload page to update selection fields
                if (results.status == 'success') {
                    notifyThenReload(results);
                }
            })
            .fail(function (xhr) {
                showGeneralError('verifyLogin');
            });
    }

    /*
     * REGISTRATION
     *********************************************/

    const formRegistration = $("#registration-form");

    formRegistration.on('submit', function (event) {
        event.preventDefault();
        // get fields
        const fields = [];
        $(this).find("input:not(.select-dropdown)").each(function () {
            fields[$(this).attr('name')] = $(this).val().trim();
        });
        fields['salutation'] = $(this).find("input.select-dropdown").val().trim();
        registerNewUser(fields);
    });

    function registerNewUser(fields) {
        // check if all needed fields are there;
        l(fields);
        if (
            !fields['city'] || !fields['email'] ||
            !fields['firstname'] ||!fields['housenumber'] ||
            !fields['lastname'] || !fields['password'] ||
            !fields['salutation'] || !fields['street'] ||
            !fields['username'] || !fields['zip']
        ) return;
        // if all fields register
        const data = {
            request: 'registerNewUser',
            token: token,
            city: fields['city'],
            email: fields['email'],
            firstname: fields['firstname'],
            housenumber: fields['housenumber'],
            lastname: fields['lastname'],
            password: fields['password'],
            salutation: fields['salutation'],
            username: fields['username'],
            zip: fields['zip'],
            street: fields['street']
        };
        $.ajax({
            type: "POST",
            url: urlAjaXInternal,
            data: data
        })
            .done(function (results) {
                // early return if status error / show custom error
                if (results.status == 'error') {
                    notify(results);
                    return;
                }
                // success: reset form and reload page
                if (results.status == 'success') {
                    notifyThenRedirect(results,'/login');
                }
            })
            .fail(function (xhr) {
                showGeneralError('registerNewUser');
            });
    }

}); // jQuery, document ready

