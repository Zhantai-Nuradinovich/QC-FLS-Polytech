<template>
  <div id="app">
<!--    <MainWindow/>-->
    <TwoQubits/>
<!--    <ThreeQubits/>-->
  </div>
</template>


<!--Только страницы которые надо загружать -->
<script>
// import MainWindow from "@/components/MainWindow";
import TwoQubits from "@/components/TwoQubits";
// import ThreeQubits from "@/components/ThreeQubits";

export default {
  name: 'App',
  components: {
    // MainWindow,
    TwoQubits,
    // ThreeQubits
  }
}

</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

</style>
