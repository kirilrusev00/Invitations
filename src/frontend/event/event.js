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
        const isAddedByCurrentUser = response.value.isAddedByCurrentUser;

        showEventInfo(response.value);
        showResponses(isAddedByCurrentUser, response.value.status, response.value.responses);
        showResponseButtons(isAddedByCurrentUser, response.value.status);
        showUploadedResources(eventId, isAddedByCurrentUser, response.value.status);
        showUploadFilesForm(eventId, isAddedByCurrentUser);
      } else {
        if (response.message === "No current user") {
          redirect("../login/login.html");
        }
        document.getElementById("event-name").innerText = response.message;
      }
    });

  return false;
})

function showEventInfo(eventInfo) {
  document.getElementById("event-info").style.display = 'flex';
  document.getElementById("event-name").innerText = eventInfo.name;
  document.getElementById("venue").innerHTML = "<b>Място: </b>" + eventInfo.venue;
  document.getElementById("start-time").innerHTML = "<b>Начало: </b>" + eventInfo.start_time;
  document.getElementById("end-time").innerHTML = "<b>Край: </b>" + eventInfo.end_time;

  eventInfo.meeting_link ?
    document.getElementById("meeting-link").innerHTML = `<b>Линк към стаята: </b> ${eventInfo.meeting_link}` :
    document.getElementById("meeting-link").style.display = "none";
  eventInfo.meeting_password ?
    document.getElementById("meeting-password").innerHTML = `<b>Линк към стаята: </b> ${eventInfo.meeting_password}` :
    document.getElementById("meeting-password").style.display = "none";
}

function showResponses(isAddedByCurrentUser, status, responses) {
  if (isAddedByCurrentUser || status !== 'not invited') {
    document.getElementById("interested").innerText = `${responses.interested} заинтересован/и ➕`;
    document.getElementById("going").innerText = responses.going + " потвърдил/и ✔️";
    document.getElementById("not-going").innerText = responses.notGoing + " отказал/и ❌";
    document.getElementById("invited").innerText = responses.invited + " чакащ/и ❔ ";
  } else {
    document.getElementById("responses").style.display = "none";
  }
}

function showResponseButtons(isAddedByCurrentUser, status) {
  if (isAddedByCurrentUser || status === 'not invited') {
    document.getElementById("response-buttons").style.display = "none";
  } else {
    if (status === 'interested') {
      document.getElementById("interested-button").disabled = true;
    }
    if (status === 'going') {
      document.getElementById("going-button").disabled = true;
    }
    if (status === 'not going') {
      document.getElementById("not-going-button").disabled = true;
    }
  }
}

function showUploadedResources(eventId, isAddedByCurrentUser, status) {
  if (isAddedByCurrentUser || status === 'going' || status === 'interested') {
    fetch(`../../backend/endpoints/get-resources.php?id=${eventId}`, {
      method: "GET",
    })
      .then((response) => response.json())
      .then((response) => {
        if (response.success) {
          //console.log(response);
          if (response.value && response.value.length > 0) {
            createResourcesSection();

            response.value.forEach(visualizeResources);
          }
        }
        else if (response.message === "No current user") {
          redirect("../login/login.html");
        }
      });
  }
}

const visualizeResources = (resourceLink) => {
  let imageLink = document.createElement("a");
  imageLink.setAttribute("href", resourceLink);
  imageLink.setAttribute("target", "_blank");

  let imagePath = resourceLink.split('.');
  const imageExtension = imagePath[imagePath.length - 1];

  let image = document.createElement("img");
  imageExtension === 'pdf' ?
    image.setAttribute("src", "../../images/pdf_file_icon.svg") :
    image.setAttribute("src", resourceLink);
  image.setAttribute("alt", "");
  image.setAttribute("class", "resource-image");

  let imageName = document.createElement("p");
  imagePath = resourceLink.split('/');
  imageName.innerText = imagePath[imagePath.length - 1];

  imageLink.appendChild(image);
  imageLink.appendChild(imageName);
  document.getElementById("resources").appendChild(imageLink);
}

function createResourcesSection() {
  let resourcesSection = document.createElement("section");
  resourcesSection.setAttribute("id", "resources");

  let resourcesHeading = document.createElement("h2");
  resourcesHeading.setAttribute("id", "resources-heading");
  resourcesHeading.innerText = "Ресурси";

  resourcesSection.appendChild(resourcesHeading);
  document.getElementById("main").appendChild(resourcesSection);
}

function showUploadFilesForm(eventId, isAddedByCurrentUser) {
  if (isAddedByCurrentUser) {
    document.getElementById("upload-files").style.display = 'block';
    document.getElementById("upload-form").action = `../../backend/endpoints/upload-files.php?id=${eventId}`;
  }
}

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
      else if (response.message === "No current user") {
        redirect("../login/login.html");
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