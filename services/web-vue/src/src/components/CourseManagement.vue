<template>
  <div class="courseManagement">
    Course Management
    <span><Users msg="Welcome to Your Vue.js App"/></span>
    <span><Courses msg="Welcome to Your Vue.js App"/></span>
  </div>
</template>

<script>
import Users from './Users.vue'
import Courses from './Courses.vue'

export default {
  name: 'CourseManagement',
  components: {
    Users,
    Courses
  }
  // data: function() {
  //   return {
  //     message : "",
  //     users: users
  //   }
  // }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  /* display: inline-block; */
  /* margin: 0 10px; */
}
a {
  color: #42b983;
}
</style>
