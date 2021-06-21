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
    fetch('../logout.php', {
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
          redirect('../login/login.html');
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