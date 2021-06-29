// const CONSTANTS = require('../constants');
/*
const onFormSubmitted = (event) => {

  // document.getElementById("submit-btn").innerHTML = "Hello World";

  console.log('1');
  event.preventDefault();

  const formElement = event.target;

  const formData = {
    email: document.getElementById("email").value,
    password: document.getElementById("password").value,
  };

  const pathLogin = 'http://localhost:8080/Invitations/src/backend/endpoints/login.php'; //CONSTANTS.getUrl('login.php');
  console.log('2');
  console.log(formData);


  fetch(pathLogin, {
    method: "POST",
    body: JSON.stringify(formData),
  })
    // .then((response) => console.log(response)) //response.json()
    .then((response) => {
      console.log(response);
      if (response.status === 200) {
        console.log("hey!");
        location.replace("../users/welcome.php");
      } else {
        document.getElementById("user-message").innerText = "Нещо се обърка!"; // response. ?
      }
    });

  return false;
};

document
  .getElementById("submit-btn")
  .addEventListener("click", onFormSubmitted);
*/