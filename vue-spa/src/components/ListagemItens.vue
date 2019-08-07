<template>
  <div v-if="estaLogado" class="espacado">
    <ul id="example-1">
      <li v-bind:key="produto" v-for="produto in produtos">{{ produto }}</li>
    </ul>
  </div>
</template>

<script>
import * as jwtHelpers from '../suporte/helpers-jwt';
export default {
  name: "ListagemItens",
  data() {
    return {
      produtos: []
    };
  },
  updated: async function(){
    console.log("parece q foi...")
    //  opcoes = {
    //    url: this.apiurl + 'lista-itens',
    //    method: 'get'
    //   };
    //   let resposta = await jwtHelpers.jwtFetch(opcoes)
    //   console.log(resposta)
  },
  props: ["estaLogado"]
};
</script>


<style scoped>
.espacado {
  margin-top: 5em;
}
</style>

