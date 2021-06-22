//adding events
const onFormSubmitted = (event) => {
    event.preventDefault();
  
    const formElement = event.target;
  
    const formData = {
      name: formElement.querySelector("input[name='name']").value,
      venue: formElement.querySelector("input[name='venue']").value,
      startTime: formElement.querySelector("input[name='startTime']").value,
      endTime: formElement.querySelector("input[name='endTime']").value,
      meetingLink: formElement.querySelector("input[name='meetingLink']").value,
      meetingPassword: formElement.querySelector("input[name='meetingPassword']").value
    };
  
    fetch("../../backend/endpoints/add-event.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json; charset=utf-8",
          },
            body: JSON.stringify(formData),
        })
        .then((response) => response.json())
        .then((response) => {
          console.log(response);
            if (response.success) {
              document.getElementById("user-message").innerText = "Събитието е добавено успешно!";
                //location.replace("./welcome.php");
            } else {
                document.getElementById("user-message").innerText = response.message;
            }
        });
  
    return false;
  };
  
  document
    .getElementById("add-event-form")
    .addEventListener("submit", onFormSubmitted);

//working with the navigation
const profileBtn = document.getElementById('profile');

profileBtn.addEventListener('click', () => {
  redirect('../profile/profile.html');
});

const eventsBtn = document.getElementById('events');

eventsBtn.addEventListener('click', () => {
  redirect("../events/events.html");
});

const logoutBtn = document.getElementById('logout');

logoutBtn.addEventListener('click', () => {
  logout();
});

function redirect(path) {
    window.location = path;
  }

