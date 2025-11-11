function validatePassword() {
    const pass = document.getElementById("password").value;
    const confirm = document.getElementById("confirmPassword").value;

    if (pass !== confirm) {
        alert("Kata sandi tidak cocok!");
        return false;
    }
    if (pass.length < 6) {
        alert("Kata sandi minimal 6 karakter!");
        return false;
    }
    return true;
}