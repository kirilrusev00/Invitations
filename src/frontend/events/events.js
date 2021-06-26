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
          let elem = document.createElement("a");
          elem.setAttribute("href", `../event/event.html?id=${event.eventId}`);
          elem.setAttribute("target", '_blank');
          elem.innerText = event.name;
          document.getElementById("events-going-interested").appendChild(elem);
        });
      }
      else {
        // redirect to login screen
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
            let elem = document.createElement("a");
            elem.setAttribute("href", `../event/event.html?id=${event.eventId}`);
            elem.setAttribute("target", '_blank');
            elem.innerText = event.name;
            document.getElementById("events-invited").appendChild(elem);
          });
        }
        else {
          // redirect to login screen
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
