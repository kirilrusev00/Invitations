window.addEventListener('load', (event) => {
  event.preventDefault();

  const url_string = window.location.href
  const url = new URL(url_string);

  const eventId = url.searchParams.get("id");

  if (!eventId) {
    return;
  }

  let isAddedByCurrentUser;

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
        document.getElementById("venue").innerText = response.value.venue;
        document.getElementById("start-time").innerText = response.value.start_time;
        document.getElementById("end-time").innerText = response.value.end_time;
        document.getElementById("meeting-link").innerText = response.value.meeting_link ? response.value.meeting_link : '';
        document.getElementById("meeting-password").innerText = response.value.meeting_password ? response.value.meeting_password : '';
        
        const isAddedByCurrentUser = response.value.isAddedByCurrentUser;
        if (isAddedByCurrentUser) {
          //console.log(isAddedByCurrentUser);
          document.getElementById("upload-files").style.display = 'block';
        }
      } else {
        document.getElementById("event-name").innerText = response.message;
      }
    });

  return false;

})

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
