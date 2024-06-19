function checklogin() {

    const password = document.getElementById('pass').value;
    const username = document.getElementById('uname').value;

    if (password == 102141 && username == test1) {
        return ture;
    } else {
        alert('Password & Username are wrong.');
        return false;
    }
}