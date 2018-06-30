
//function to expend the menu
function expand_menu() {
    if (document.getElementById('menu-items').style.display == 'block') {
        document.getElementById('menu-items').style.display = 'none';
        document.getElementById('menu-switch').innerHTML = 'Menu';
    }
    else {
        document.getElementById('menu-items').style.display = 'block';
        document.getElementById('menu-switch').innerHTML = 'Close';
    }
};

function toogle_booking_menu() {
    if(document.getElementById('booking_menu_items').style.display == "none") {
        document.getElementById('booking_menu_items').style.display = "inline";
    }
    else {
        document.getElementById('booking_menu_items').style.display = "none";
    }
}

//functions to check 2 empty fields
function check2Fields(field1, field2) {

    // var myForm = document.forms.theform;
    var field1 = document.getElementById(field1);
    var field2 = document.getElementById(field2);

    if(field1.value == "") {
        field1.style.background = 'red';
    }

    if(field2.value == "") {
        field2.style.background = 'red';
    }

    if(field1.value == "" || field2.value == "") {
        document.getElementsByClassName('notice error')[0].innerHTML = "Please fill out the empty fields in red!";
    }
    else {
        document.getElementById('buttonSubmit').type = 'Submit';
    }
}

//function to set 2 fields as required
function setRequired(field1, field2) {
    // var myForm = document.forms.theform;
    var field1 = document.getElementById(field1);
    var field2 = document.getElementById(field2);
    var Service_TypeId = document.getElementById("Service_TypeId").value;

    if(Service_TypeId == 1) {
        field1.setAttribute('required', 'required');
        field1.style.background = 'red';
        field1.setAttribute('placeholder', 'Vehicle Type');
        field1.style.color = 'white';
    }
    else {
        field1.removeAttribute('required');
        field1.style.background = '';
        field1.setAttribute('placeholder', '');
        field1.style.color = '';
    }
}

//function to check if date2 is bigger than date1
function compareDates(date1, date2) {
    var date1 = document.getElementById(date1);
    var date2 = document.getElementById(date2);

    if (date1.value > date2.value) {
        document.getElementsByClassName('notice error')[0].innerHTML = 'Please fill out the validity dates properly!';
        date1.style.background = 'red';
        date2.style.background = 'red';
    }
}
