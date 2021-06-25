window.addEventListener('load', (event) => {
  event.preventDefault();

  fetch('../../backend/endpoints/get-current-user.php', {
    method: "GET",
  })
    .then((response) => response.json())
    .then((response) => {
      if (response.success && response.message === 'Current user info') {
        document.getElementById("first-name").innerText = response.value.firstName;
        document.getElementById("last-name").innerText = response.value.lastName;
        document.getElementById("email").innerText = response.value.email;
        document.getElementById("specialty").innerText = response.value.specialty;
        document.getElementById("fn").innerText = response.value.fn;
        document.getElementById("course").innerText = response.value.course;
      }
      else {
        // redirect to login screen
      }
    });

  fetch('../../backend/endpoints/get-all-events-by-current-user.php', {
    method: "GET",
  })
    .then((response) => response.json())
    .then((response) => {
      if (response.success && response.message === 'Events by current user') {
        response.value.forEach(event => {
          let elem = document.createElement("a");
          elem.setAttribute("href", `../event/event.html?id=${event.id}`);
          elem.setAttribute("target", '_blank');
          elem.innerText = event.name;
          document.getElementById("event-list").appendChild(elem);
        });
      }
      else {
        // redirect to login screen
      }
    });

  return false;

})

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

function logout() {
  fetch('../../logout.php', {
    method: 'GET'
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error('Error logout user.');
      }
      return response.json();
    })
    .then(response => {
      if (response.success) {
        redirect('../login/index.html');
      }
    })
    .catch(error => {
      const message = 'Error logout user.';
      console.error(message);
    });
}

function redirect(path) {
  window.location = path;
}

