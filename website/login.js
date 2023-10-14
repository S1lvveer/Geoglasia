let form = document.querySelector("form")
let inputs = document.querySelectorAll("input");
/* inputs[0] - username/login, inputs[1] - password, inputs[2] - remember me */

let show_button = document.querySelector("#showpassword");
let show_icon = document.querySelector("#showpassword-icon");

let show = false;
show_button.addEventListener("click", () => {
    show = !show;

    if (show) {
        inputs[1].type = "text";
        show_icon.name = "eye-off-outline";
    } else {
        inputs[1].type = "password"
        show_icon.name = "eye-outline";
    }
        
})

let submit = document.querySelector("form #submit");
submit.addEventListener("click", (e) => {
    e.preventDefault();

    // hide password for last time right before submitting
    inputs[1].type = "password";
    show_icon.name = "eye-outline";
})

//function that switches between login and register
function form_visibility(which){
    let form_login = document.getElementById("form-login");
    let form_register = document.getElementById("form-register");

    if(which === 'login'){
        form_login.style.display = "block";
        form_register.style.display = "none";

    } else if(which === 'register') {
        form_login.style.display = "none";
        form_register.style.display = "block";
    }
}