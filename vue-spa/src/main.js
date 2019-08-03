import Vue from 'vue'
import App from './App.vue'
import 'materialize-css';
import 'materialize-css/dist/css/materialize.min.css';




// Vue.config.productionTip = false


new Vue({
  render: h => h(App),
  mounted: () => {
    // App.methods.atualizaUsuario()
    alert("ola mundo 1")
  }
}).$mount('#app')

