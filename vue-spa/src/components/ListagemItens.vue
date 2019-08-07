<template>
  <div v-if="estaLogado" class="espacado">
    <ul id="example-1">
      <li v-bind:key="produto" v-for="produto in produtos">{{ produto }}</li>
    </ul>
  </div>
</template>

<script>
import { pJwtFetch } from "../suporte/helpers-jwt";
export default {
  name: "ListagemItens",
  data() {
    return {
      produtos: []
    };
  },
  mounted: function() {
    let opcoes = {
      url: this.apiurl + "lista-itens",
      method: "get"
    };

    pJwtFetch(opcoes)
      .then(resultado => {
        this.produtos = resultado;
      })
      .catch(codigo => {
        this.$emit("abrirmodallogin");
      });
  },
  props: ["estaLogado", "apiurl"]
};
</script>


<style scoped>
.espacado {
  margin-top: 5em;
}
</style>

