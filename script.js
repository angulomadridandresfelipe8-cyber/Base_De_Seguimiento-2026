function register() {
    let user = document.getElementById("newUser").value;
    let pass = document.getElementById("newPass").value;

    localStorage.setItem(user, pass);
    alert("Usuario creado");
}

function login() {
    let user = document.getElementById("usuario").value;
    let pass = document.getElementById("password").value;

    if(localStorage.getItem(user) === pass) {
        localStorage.setItem("activo", user);
        window.location = "dashboard.html";
    } else {
        alert("Datos incorrectos");
    }
}