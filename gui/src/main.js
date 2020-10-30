import Vue from 'vue'
import App from './App.vue'
require('bootstrap/dist/css/bootstrap.css');
import vueDebounce from 'vue-debounce'

Vue.use(vueDebounce)
Vue.config.productionTip = false

new Vue({
  render: h => h(App),
}).$mount('#app')
