
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';
import 'mdb-vue-ui-kit/css/mdb.min.css';



import '@fortawesome/fontawesome-free/css/all.css';
import { createPinia } from 'pinia'; // Import createPinia function
const pinia = createPinia();
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(router)
app.use(pinia);
app.mount('#app')
