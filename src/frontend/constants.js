export const getUrl = name => {
    switch (name) {
        case "login.php":
            return "http://localhost:8080/Invitations/src/backend/endpoints/login.php";
        case "login.html":
            return "http://localhost:8080/Invitations/src/frontend/login/index.php";
        case "register.php":
            return "http://localhost:8080/Invitations/src/backend/endpoints/register.php";
        case "register.html":
            return "http://localhost:8080/Invitations/src/frontend/register/register.html";
        case "logout.php":
            return "http://localhost:8080/Invitations/src/backend/endpoints/logout.php";
    }
}