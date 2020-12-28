<template>
  <div id="app">
    <h1> Поиск на 3ёх кубитах. </h1>
    <div class="mainPanel">
      <input v-model="message" placeholder="введите число от 0 до 4">
      <p>Введённое сообщение: {{ message }}</p>
    </div>
    <div class="white">
      <img :src="image">
    </div>
  </div>
</template>

<script>
import image from "../assets/white.png"


export default {
  name: "ThreeQubits",
  props: {
    message: String
  },
  data: function () {
    return {
      image: image,
    }
  }
}
</script>

<style scoped>
.mainPanel {
  float: left;
  margin: 7px;
}

.white {
  position: absolute;
  top: 180px;
  float: left;
  width: 500px;
  border: 2px solid black;
  margin: 5px;

}

.white img {
  width: 70%;
  height: 70%;
}

</style>