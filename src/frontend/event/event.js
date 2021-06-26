window.addEventListener('load', (event) => {
  event.preventDefault();

  const url_string = window.location.href
  const url = new URL(url_string);

  const eventId = url.searchParams.get("id");

  if (!eventId) {
    return;
  }

  fetch(`../../backend/endpoints/get-event.php?id=${eventId}`, {
    method: "GET",
  })
    .then((response) => response.json())
    .then((response) => {
      //console.log(response);
      if (response.success) {
        document.getElementById("event-info").style.display = 'block';
        //console.log(response.value);
        document.getElementById("event-name").innerText = response.value.name;
        document.getElementById("venue").innerHTML= "<b>Място: </b>" + response.value.venue;
        document.getElementById("start-time").innerHTML = "<b>Начало: </b>" + response.value.start_time;
        document.getElementById("end-time").innerHTML = "<b>Край: </b>" + response.value.end_time;
        document.getElementById("meeting-link").innerHTML = `<b>Линк към стаята: </b> ${response.value.meeting_link ? response.value.meeting_link : ''}`;
        document.getElementById("meeting-password").innerHTML = `<b>Парола за стаята: </b> ${response.value.meeting_password ? response.value.meeting_password : ''}`;

        const isAddedByCurrentUser = response.value.isAddedByCurrentUser;

        if (isAddedByCurrentUser || response.value.status !== 'not invited') {
          document.getElementById("interested").innerText = `${response.value.responses.interested} се интересуват`;
          document.getElementById("going").innerText = response.value.responses.going + " ще присъстват";
          document.getElementById("not-going").innerText = response.value.responses.notGoing + " няма да присъстват";
          document.getElementById("invited").innerText = response.value.responses.invited + " са поканени";
        } else {
          document.getElementById("responses").style.display = "none";
        }

        if (isAddedByCurrentUser || response.value.status === 'not invited') {
          document.getElementById("response-buttons").style.display = "none";
        } else {
          if (response.value.status === 'interested') {
            document.getElementById("interested-button").disabled = true;
          }
          if (response.value.status === 'going') {
            document.getElementById("going-button").disabled = true;
          }
          if (response.value.status === 'not going') {
            document.getElementById("not-going-button").disabled = true;
          }
        }

        if (isAddedByCurrentUser || response.value.status === 'going' || response.value.status === 'interested') {
          fetch(`../../backend/endpoints/images-display.php?id=${eventId}`, {
            method: "GET",
          })
            .then((response) => response.json())
            .then((response) => {
              if (response.success) {
                //console.log(response.value);
                if (response.value) {
                  let resourcesSection = document.createElement("section");
                  resourcesSection.setAttribute("id", "resources");
                  document.getElementById("main").appendChild(resourcesSection);
                }
                response.value.forEach(element => {
                  let elem = document.createElement("img");
                  elem.setAttribute("src", element);
                  elem.setAttribute("alt", "");
                  elem.setAttribute("style", "max-height:600px; max-width:600px; margin-bottom :0px;");
                  // elem.setAttribute("style", "max-width:600px;");
                  // elem.setAttribute("style", "margin-bottom :20px;");
                  document.getElementById("resources").appendChild(elem);
                });
              }
              //console.log(response)
            });
        }

        if (isAddedByCurrentUser) {
          //console.log(isAddedByCurrentUser);
          document.getElementById("upload-files").style.display = 'block';
          document.getElementById("upload-form").action = `../../backend/endpoints/upload-files.php?id=${eventId}`;
        }
      } else {
        document.getElementById("event-name").innerText = response.message;
      }
    });

  return false;

})


function sendUpdateResponseRequest(newStatus) {
  const url_string = window.location.href
  const url = new URL(url_string);

  const eventId = url.searchParams.get("id");

  if (!eventId) {
    return;
  }

  const formData = {
    eventId,
    status: newStatus
  };

  fetch("../../backend/endpoints/update-response-status.php", {
    method: "POST",
    body: JSON.stringify(formData),
  })
    .then((response) => response.json())
    .then((response) => {
      if (response.success) {
        location.reload();
      }

    });

  return false;
}

const interestedButton = document.getElementById('interested-button');
interestedButton.addEventListener('click', () => sendUpdateResponseRequest('interested'));

const goingButton = document.getElementById('going-button');
goingButton.addEventListener('click', () => sendUpdateResponseRequest('going'));

const notGoingButton = document.getElementById('not-going-button');
notGoingButton.addEventListener('click', () => sendUpdateResponseRequest('not going'));

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