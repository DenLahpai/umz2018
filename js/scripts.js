function checkEmptyField() {
    var inputs = document.getElementsByTagName('input');
    for (var i = 1; i < inputs.length; i++) {
        a
    }
}

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
