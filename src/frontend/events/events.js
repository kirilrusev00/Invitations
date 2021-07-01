window.addEventListener('load', (event) => {
  event.preventDefault();

  fetch('../../backend/endpoints/get-all-events-interested-going.php', {
    method: "GET",
  })
    .then((response) => response.json())
    .then((response) => {
      //console.log(response);


      if (response.success && response.message === 'Events interested or going for current user') {
        response.value.forEach(event => {
          let sectionElement = document.createElement("a");
          sectionElement.setAttribute("id", "accepted-event");
          sectionElement.setAttribute("href", `../event/event.html?id=${event.eventId}`);
          sectionElement.setAttribute("target", "_blank");
          sectionElement.setAttribute("class", "accepted-event");
          let titleElement = document.createElement("p");
          titleElement.innerHTML = `<b>${event.name}</b>`;
          sectionElement.appendChild(titleElement);
          let dateElement = document.createElement("p");
          dateElement.innerText = event.startTime;
          sectionElement.appendChild(dateElement);
          document.getElementById("events-going-interested").appendChild(sectionElement);
        });
      }
      else if (response.message === "No current user") {
        redirect("../login/login.html");
      }
    });

  fetch('../../backend/endpoints/get-all-events-invited.php', {
    method: "GET",
  })
    .then((response) => response.json())
    .then((response) => {
      //console.log(response);

      if (response.success && response.message === 'Events invited for current user') {
        response.value.forEach(event => {
          let sectionElement = document.createElement("a");
          sectionElement.setAttribute("id", "invited-event");
          sectionElement.setAttribute("href", `../event/event.html?id=${event.eventId}`);
          sectionElement.setAttribute("target", "_blank");
          sectionElement.setAttribute("class", "invited-event");
          let titleElement = document.createElement("p");
          titleElement.innerHTML = `<b>${event.name}</b>`;
          sectionElement.appendChild(titleElement);
          let dateElement = document.createElement("p");
          dateElement.innerText = event.startTime;
          sectionElement.appendChild(dateElement);
          document.getElementById("events-invited").appendChild(sectionElement);
        });
      }
      else if (response.message === "No current user") {
        redirect("../login/login.html");
      }
    });

  return false;

});

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
  fetch('../../backend/endpoints/logout.php', {
    method: 'GET'
  })
    .then(response => response.json())
    .then((response) => {
      if (!response.success) {
        throw new Error('Error logout user.');
      }
      redirect('../login/login.html');
    })
    .catch(error => {
      const message = 'Error logout user.';
      console.error(message);
    });
}

function redirect(path) {
  window.location = path;
}
