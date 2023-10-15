const form_login = document.getElementById("form-login");
const form_register = document.getElementById("form-register");

// function to show/hide password [element = <a> from the eyeball]
function password_visibility(element) {
    let icon = element.querySelector("ion-icon");
    let pass_input = element.parentElement.querySelector("input.pass");

    if (icon.name === "eye-outline") {
        icon.name = "eye-off-outline";
        pass_input.type = "text";
    } else {
        icon.name = "eye-outline";
        pass_input.type = "password";
    }
}


//function that switches between login and register
function form_visibility(which){
    if(which === 'login'){
        form_login.style.display = "block";
        form_register.style.display = "none";

    } else if(which === 'register') {
        form_login.style.display = "none";
        form_register.style.display = "block";
    }
}