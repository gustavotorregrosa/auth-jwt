<template>
  <div id="modal2" class="modal">
    <div class="modal-content">
      <h6>Registrar</h6>
      <form class="col s12">
        <div class="row">
          <div class="input-field col s12">
            <input v-model.lazy="usuario.name" id="name" type="text" class="validate" />
            <label for="name">Name</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input v-model.lazy="usuario.email" id="email" type="email" class="validate" />
            <label for="email">Email</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input v-model.lazy="usuario.password" id="password" type="password" class="validate" />
            <label for="password">Password</label>
          </div>
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <a @click.prevent="registrar" class="modal-close waves-effect waves-green btn-flat">Registrar</a>
    </div>
  </div>
</template>

<script>
import M from "materialize-css";
document.addEventListener("DOMContentLoaded", function() {
  let elem = document.querySelector("#modal2");
  let instances = M.Modal.init(elem, {});
});

export default {
  name: "ModalRegistro",
  data() {
    return {
      usuario: {
        name: "",
        email: "",
        password: ""
      }
    };
  },
  
  methods: {
    registrar: function() {
      this.$emit('registrarusuario', this.usuario)
    }
  }
};
</script>
