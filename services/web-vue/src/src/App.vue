<template>
  <div id="app">
    <!-- <img alt="Vue logo" src="./assets/logo.png"> -->
    <div>
      <span><Users msg="Welcome to Your Vue.js App"/></span>
      <span><Courses msg="Welcome to Your Vue.js App"/></span>
    </div>
  </div>
</template>

<script>
//import HelloWorld from './components/HelloWorld.vue'
import Users from './components/Users.vue'
import Courses from './components/Courses.vue'

export default {
  name: 'app',
  components: {
    Users,
    Courses
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
