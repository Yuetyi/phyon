function checkPasswords() {

    const password =  document.getElementById('pass').value;
    const repeatPassword = document.getElementById('repass').value;

    if (password === repeatPassword) {
        return ture;
    } else {
        alert('Password and repeat password do not match.');
        return false;
    }
}

function validateForm() {
    var x = document.forms["myForm"]["uname"].value;
    var y = document.forms["myForm"]["pass"].value;
    var z = document.forms["myForm"]["repass"].value;
    var a = document.forms["myForm"]["email"].value;
    var b = document.forms["myForm"]["num"].value;
    var c = document.forms["myForm"]["fax"].value;
    var d = document.forms["myForm"]["address"].value;
    if (x == "" || x == null||y == "" || y == null||z == "" || z == null||a == "" || a == null||b == "" || b == null||c == "" || c == null||d == "" || d == null) {
      alert("must be filled out");
      return false;
    }
  }