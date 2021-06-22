const onFormSubmitted = (event) => {
  event.preventDefault();

  const formElement = event.target;

  const formData = {
    email: formElement.querySelector("input[name='email']").value,
    password: formElement.querySelector("input[name='password']").value,
  };

  fetch("../../backend/endpoints/login.php", {
    method: "POST",
    body: JSON.stringify(formData),
  })
    .then((response) => response.json())
    .then((response) => {
      if (response.success) {
        location.replace("../../welcome.php");
      } else {
        document.getElementById("user-message").innerText = response.message;
      }
    });

  return false;
};

document
  .getElementById("login-form")
  .addEventListener("submit", onFormSubmitted);