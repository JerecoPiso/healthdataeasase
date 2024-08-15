import axios from 'axios';

window.axios = axios;
window.axios.defaults.withCredentials = true;
window.axios.defaults.withXSRFToken = true;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.baseurl = 'http://localhost:8180/healthdataeasase/public/'