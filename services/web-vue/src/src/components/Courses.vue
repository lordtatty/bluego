<template>
  <div class="courses">
    Courses:
    <ul id='courses-list'>
      <li v-bind:key="courses.uniqueId" v-for="course in courses">
        {{ course.course_code }}
      </li>
    </ul>
  </div>
</template>

<script>
import Axios from 'axios'

var courses = [];
Axios.get("http://localhost:8081/test/courses/get/all")
  .then(function(response) {
    for(var i = 0; i < response.data.data.length; i++){
      courses.push(response.data.data[i].attributes)
    }
  })
  .catch(function (error){
    console.log(error)
  });
console.log(courses);
export default {
  name: 'Courses',
  data: function() {
    return {
      message : "",
      courses: courses
    }
  },
  props: {
    msg: String
  }
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
