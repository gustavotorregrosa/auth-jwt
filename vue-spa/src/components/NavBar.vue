<template>
  <nav class="purple darken-4">
    <div class="nav-wrapper">
      <a href="#" class="brand-logo">Logo</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li v-if="!estaLogado">
          <a class="modal-trigger" href="#modal1">Login</a>
        </li>
        <li v-if="!estaLogado">
          <a class="modal-trigger" href="#modal2">Registrar</a>
        </li>
        <li v-if="estaLogado">{{ usuario.email }}</li>
        <li v-if="estaLogado">
          <a @click.prevent="logout" href="#">Logout</a>
        </li>
      </ul>
    </div>
  </nav>
</template>


<script>
export default {
  name: "NavBar",
  props: ["usuario"],
  computed: {
    estaLogado: function() {
      if (this.usuario) {
        return true;
      }
      return false;
    }
  }
};
</script>


