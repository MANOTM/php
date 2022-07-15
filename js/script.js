const container = document.querySelector(".container"),
  pwShowHide = document.querySelectorAll(".showHidePw"),
  pwFields = document.querySelectorAll(".password"),
  signUp = document.querySelector(".signup-link"),
  tryAgain = document.getElementById("tryAgain"),
  finput = document.getElementById("finput"),
  login = document.querySelector(".login-link");


// show/hide password and change icon
pwShowHide.forEach((eyeIcon) => {
  eyeIcon.addEventListener("click", () => {
    pwFields.forEach((pwField) => {
      if (pwField.type === "password") {
        pwField.type = "text";

        eyeIcon.src = "icon/hidden.png";
      } else {
        pwField.type = "password";

        eyeIcon.src = "icon/eye.png";
      }
    });
  });
});

//  appear signup and login form
signUp.addEventListener("click", () => {
  container.classList.add("active");
});
login.addEventListener("click", () => {
  container.classList.remove("active");
});

// focus on input when click on try again
tryAgain.onclick = () => {
  finput.focus();
};