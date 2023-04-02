import './bootstrap';
import { createApp } from 'vue';
import VueTabs from 'vue-nav-tabs';
import MessageTabs from './components/MessageTabs.vue';
const app = createApp({});

app.component('message-tabs', MessageTabs);

app.use(VueTabs);

app.mount('#app');
