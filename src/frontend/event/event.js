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
        document.getElementById("venue").innerText = response.value.venue;
        document.getElementById("start-time").innerText = response.value.start_time;
        document.getElementById("end-time").innerText = response.value.end_time;
        document.getElementById("meeting-link").innerText = response.value.meeting_link ? response.value.meeting_link : '';
        document.getElementById("meeting-password").innerText = response.value.meeting_password ? response.value.meeting_password : '';

        const isAddedByCurrentUser = response.value.isAddedByCurrentUser;



        fetch(`../../backend/endpoints/images-display.php?id=${eventId}`, {
          method: "GET",
        })
          .then((response) => response.json())
          .then((response) => {
            if (response.success) {
              console.log(response.value);
              response.value.forEach(element => {
                let elem = document.createElement("img");
                elem.setAttribute("src", element);
                elem.setAttribute("alt", "");
                document.getElementById("resources").appendChild(elem);
              });
            }
            console.log(response)
          });

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