<template>
  <div id="app">
    <h1> Поиск на 2ух кубитах. </h1>
    <div class="mainPanel left_border">
      <input type="text"
             @input="message = $event.target.value"
             :value="message">
      <!--      <p>Введённое сообщение: {{ message }}</p>-->
      <input class="button-primary" type="submit" value="Send">
    </div>
    <div class="white">
      <img :src="image">
    </div>
  </div>
</template>

<script>
import image from "../assets/white.png"

// import gql from "graphql-tag";

// const ADD_TWO = gql`
//   mutation addTwo(
//     $message: String!
//   ) {
//     insert_number(
//       objects: [
//         {
//           message: $message
//         }
//       ]
//     ) {
//       returning {
//         id
//       }
//     }
//   }
// `;

export default {
  name: "TwoQubits",
  data: function () {
    return {
      image: image,
      message: 'введите число от 0 до 4',
    }
  },
  apollo: {},
  methods: {
    submit(e) {
      e.preventDefault();
      const {message} = this.$data;
      this.$apollo.mutate({
        mutation: ADD_TWO,
        variables: {
          message
        },
        refetchQueries: ["getNumbers"]
      });
    }
  }
}

</script>

<style scoped>
.mainPanel {
  position: static;
  float: left;
  margin: 7px;
}

.white {
  position: absolute;
  top: 220px;
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