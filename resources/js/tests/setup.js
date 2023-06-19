import Vue from 'vue';
import lodash from 'lodash';
import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue';
import VueClipboard from 'vue-clipboard2';
import 'intersection-observer';

import axios from 'axios';

import VuePhoneNumberInput from 'vue-phone-number-input';

window.axios = axios;

require('../filters');
window.moment = require('moment');

Vue.use(VueClipboard);
global._ = lodash;

Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);
Vue.mixin(require('@/mixin'));
require('@/components');

Vue.component('vue-phone-number-input', VuePhoneNumberInput);

window.details = {
  name: 'BuilderLaravel',
  description: 'A foo app',
  url: 'https://builder_laravel.test',
  email: 'email@example.com',
};
