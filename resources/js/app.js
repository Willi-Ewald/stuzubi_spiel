import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue';
import axios from 'axios';

import.meta.glob([
    './components/assets/**'
])


axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF-Token nicht gefunden. Stellen Sie sicher, dass es im Meta-Tag vorhanden ist.');
}
createApp(App)
    .mount('#app');
