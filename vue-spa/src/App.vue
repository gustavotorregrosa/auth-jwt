<template>
  <div id="app">
    <header>
      <NavBar @logout="logout()" :usuario="usuario" :estaLogado="estaLogado" />
    </header>
    <main>
      <div class="container">
        <ListagemItens :estaLogado="estaLogado" />
      </div>
    </main>
  </div>
</template>

<script>
import NavBar from "./components/NavBar.vue";
import ListagemItens from "./components/ListagemItens.vue";
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
  computed: {
    estaLogado: function() {
      if (this.usuario) {
        return true;
      }
      return false;
    }
  },

  // mounted: function() {
  //   this.usuario = JSON.parse(localStorage.getItem("meuUsuario"));
  // },

  methods: {
    logout: function() {
      localStorage.removeItem("meuJwt");
      localStorage.removeItem("meuUsuario");
      this.usuario = null;
    }
  },

  components: {
    NavBar,
    ListagemItens
  }
};
</script>


