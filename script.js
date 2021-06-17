function preview() {
    thumb.src=URL.createObjectURL(event.target.files[0]);
 }
 //see password
 const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');
togglePassword.addEventListener('click', function (e) {
  // toggle the type attribute
  const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
  password.setAttribute('type', type);
  // toggle the eye / eye slash icon
  this.classList.toggle('bi-eye');
});
 /*document.getElementById('select-all').onclick = function() {
    var checkboxes = document.getElementsByName('list');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
}
function myFunction() {
    var x = document.getElementById("myDIV");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  }
  function ShowDiv() {
    document.getElementById("myDiv").style.display = "";
}*/