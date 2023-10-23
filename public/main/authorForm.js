const userName = document.querySelector("#form_username");
const email = document.querySelector("#form_email");
const submit = document.querySelector("#form_Submit");
const alerts = document.querySelectorAll(".alert");


submit.addEventListener("click", () => {
  let regxUser = /^[a-z]+$/gi;
  let regxEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  if (!regxUser.test(userName.value) || userName.value === "") {
    userName.classList.add("redlabel");
    alerts[0].classList.add("show");
  }
  if (!regxEmail.test(email.value) || email.value === "") {
    email.classList.add("redlabel");
    alerts[1].classList.add("show");
  }
});
