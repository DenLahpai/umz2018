
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
        alert('Please fill out the empty field(s) in red!');
    }
    else {
        document.getElementById('buttonSubmit').type = 'Submit';
    }
}
