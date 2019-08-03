<template>
  <div id="app">
    <header>
      <NavBar :usuario="usuario" />
    </header>
    <br />
  </div>
</template>

<script>
import NavBar from "./components/NavBar.vue";
// import * as jwtHelpers from './suporte/helpers-jwt';

export default {
  name: "app",
  data() {
    return {
      usuario: {
        nome: "Gustavo",
        email: "gustavo.torregrosa@gmail.com"
      },
      apiurl: "http://jwt-backend.test/api/"
    };
  },

  mounted: function() {
    // console.log(this.usuario);
    // this.usuario.email = "felipe@gmail.com"
    // this.usuario.email = localStorage.getItem('meuUsuario')
  },


  components: {
    NavBar
  }
};
</script>


