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

let submit = document.querySelector("form button");
submit.addEventListener("click", (e) => {
    e.preventDefault();

    // hide password for last time right before submitting
    inputs[1].type = "password";
    show_icon.name = "eye-outline";
})