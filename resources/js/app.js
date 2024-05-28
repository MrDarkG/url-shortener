import { createApp } from 'vue';
import Welcome from './components/Welcome.vue';
import 'bootstrapCss';
import "bootstrap";
let app = createApp({})

app.component('example', Welcome)

app.mount('#app')