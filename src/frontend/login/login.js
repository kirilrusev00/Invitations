const onFormSubmit = async (event) => {
  const form = document.getElementById("login-form");
  const inputElements = document.querySelectorAll("input");
  const responseMessage = document.getElementById("response-message");

  event.preventDefault();

  responseMessage.classList.add("hide");
  responseMessage.innerHTML = null;

  let formData = {};
  inputElements.forEach((input) => {
    formData[input.name] = input.value;
  });

  console.log('hi');
  const pathLogin = '../../backend/endpoints/login.php';
  try {
    const loginResponse = fetch(pathLogin, {
      method: "POST",
      headers: { "Content-Type": "application/json", },
      body: JSON.stringify(formData),
    })
      .then(res => res.json())
      .then(res => console.log(res));


    console.log(await loginResponse);
    // const responseData = await loginResponse.json();
    // signIn(loginResponse);
  }
  catch (err) { throw err; }
};

const signIn = async (responseData) => {
  // const redirectToHome = window.location.replace("../users/welcome.php");
  console.log(responseData);
  // responseData.success ? window.location.replace("../users/welcome.php") : showErrorMessage("Нещо се обърка!");
};

const showErrorMessage = (/** @type {string} */ message) => {
  const responseMessage = document.getElementById("response-message");
  responseMessage.classList.remove("hide");
  responseMessage.innerText = message;
};

(() => {
  document
    .getElementById("submit-btn")
    .addEventListener("click", onFormSubmit);
})();