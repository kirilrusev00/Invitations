import { getUrl } from '../constants';

const redirect = (path) => { window.location = path; };

export const logout = () => {
    fetch(getUrl("logout.php"), { method: 'GET' })
        .then((res) => res.json())
        .then(res => {
            if (res.success) redirect(getUrl("login.html"));
        })
        .catch(error => {
            console.error(error);
        });
};