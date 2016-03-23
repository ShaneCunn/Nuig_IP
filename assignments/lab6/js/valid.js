function formValidation() {
    var uname = document.registration.username;
    var ucountry = document.registration.country;
    //var uzip = document.registration.zip;
    var uemail = document.registration.email;
    var umessage = document.registration.message;
    if (allLetter(uname)) {
        if (countryselect(ucountry)) {
            if (ValidateEmail(uemail)) {


                if (validmessage(umessage)) {
                }

            }
        }

    }
    return false;

}

function allLetter(uname) {
    var letters = /^[A-Za-z]+$/;
    if (uname.value.match(letters)) {
        return true;
    }
    else {
        alert('Your name must have alphabet characters only');
        uname.focus();
        return false;
    }
}

function countryselect(ucountry) {
    if (ucountry.value == "Default") {
        alert('Select your country from the list');
        ucountry.focus();
        return false;
    }
    else {
        return true;
    }
}

function ValidateEmail(uemail) {
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (uemail.value.match(mailformat)) {
        return true;
    }
    else {
        alert("You have entered an invalid email address!");
        uemail.focus();
        return false;
    }
}
function validmessage(umessage) {
    var letters = /^[0-9a-zA-Z]+$/;
    if (umessage.value.match(letters)) {
        alert('Your Question Will Be Answered Soon!');
        window.location.reload();
        return true;
    }
    else {
        alert('Message must be alphanumeric characters only');
        umessage.focus();
        return false;
    }

}



