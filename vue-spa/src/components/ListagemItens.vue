<template>
  <div v-if="estaLogado" class="espacado">
    <ul id="example-1">
      <li v-bind:key="produto" v-for="produto in produtos">{{ produto }}</li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "ListagemItens",
  data() {
    return {
      produtos: ["chimarrao", "sabao", "celular"]
    };
  },
  props: ["estaLogado"]
};
</script>


<style scoped>
.espacado {
  margin-top: 5em;
}
</style>

