import Vue from 'vue';
import VueRouter from 'vue-router';
import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue';
import '../sass/main.scss';
Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);
import routes from './router/routes';
import store from './store';
import './spark-bootstrap.js';
import VueClipboard from 'vue-clipboard2';
VueClipboard.config.autoSetContainer = true;

Vue.use(VueClipboard);

Vue.use(VueRouter);

require('./filters');

Vue.mixin(require('./mixin'));

require('./components');

import VuePhoneNumberInput from 'vue-phone-number-input';
import 'vue-phone-number-input/dist/vue-phone-number-input.css';

Vue.component('vue-phone-number-input', VuePhoneNumberInput);

const originalPush = VueRouter.prototype.push;
VueRouter.prototype.push = function push(location) {
  return originalPush.call(this, location).catch(err => {});
};

let router = new VueRouter(routes);

router.beforeEach((to, from, next) => {
  const auth = to.matched[0].meta;

  if (auth?.requiresAuth === true || auth?.requiresAdmin === true) {
    if (!window.User) {
      localStorage.setItem('original-to-path', to.path);
      next({ name: 'login' });
    } else {
      if (auth?.requiresAuth === true) {
        next();
      }

      if (auth?.requiresAdmin === true) {
        if (window.User.admin) {
          next();
        } else {
          next({ name: 'welcome' });
        }
      }
    }
  } else {
    if (auth?.requiresGuest === true) {
      if (!window.User) {
        next();
      } else {
        next({ name: 'home' });
      }
    } else {
      next();
    }
  }
});

const app = new Vue({
  el: '#app',
  router: router,
  store,
  data() {
    return {
      cart: null,
    };
  },
  created() {
    if (window.User) {
      this.$store.commit('user', window.User);
    }
    this.loadCart();
  },
  methods: {
    loadCart() {
      axios
        .get(`/api/v1/cart`)
        .then(results => {
          this.cart = results.data.cart;
        })
        .catch(error => {
          this.$root.$emit('sendMessage', 'Failed to load Cart');
        })
        .finally(f => {
          this.loadOfflineCart();
        });
    },
    loadOfflineCart() {
      let offlineCart = JSON.parse(localStorage.getItem('cart'));
      if (offlineCart) {
        for (let index = 0; index < offlineCart.length; index++) {
          const offlineCartItem = offlineCart[index];

          let onlineCart = this.cart;

          for (let j = 0; j < onlineCart.length; j++) {
            const onlineCartItem = onlineCart[j];
            if (onlineCartItem.id === offlineCartItem.id) {
              if (onlineCartItem.quantity !== offlineCart.quantity) {
                //cart update time
              }
            }
          }
        }
      }
    },
    setCart(cart) {},
  },
});

window.Vue = app;
window.Bus = new Vue();
