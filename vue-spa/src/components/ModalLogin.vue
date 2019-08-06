<template>
  <div id="modal1" class="modal">
    <div class="modal-content">
      <h6>Login</h6>
      <form class="col s12">
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
      <a @click.prevent="login" class="modal-close waves-effect waves-green btn-flat">Login</a>
    </div>
  </div>
</template>

<script>
import M from "materialize-css";
document.addEventListener("DOMContentLoaded", function() {
  let elem = document.querySelector("#modal1");
  let instances = M.Modal.init(elem, {});
});

export default {
  name: "ModalLogin",
  data() {
    return {
      usuario: {
        email: "",
        password: ""
      }
    };
  },
  methods: {
    login: function() {
       this.$emit('logarusuario', this.usuario)
    }
  }
};
</script>