import { createApp } from 'vue'



import App from './App.vue'
import router from './router'
import axios from 'axios'
import store from './store'
import i18n from './i18n'
import VueCookies from 'vue-cookies';
import Toaster from "@meforma/vue-toaster";
import CanvasJSChart from '@canvasjs/vue-charts';

//import common from './common'

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';




const app = createApp(App)
app.config.globalProperties.$axios = axios;
import Emitter from 'tiny-emitter'
window.emitter = new Emitter()
app.component("modal", {
  template: "#modal-template"
});

app.use(router)
app.use(Toaster)
app.use(VueSweetalert2)
app.use(i18n)
app.use(VueCookies)
app.use(store)
app.use(CanvasJSChart); // install the CanvasJS Vuejs Chart Plugin
app.mount('#app')
    


