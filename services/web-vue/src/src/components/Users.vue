<template>
  <div class="users">
    Users:
    <ul id='users-list'>
      <li v-bind:key="user.uniqueId" v-for="user in users">
        {{ user.forename }} {{ user.surname }}
      </li>
    </ul>
  </div>
</template>

<script>
import Axios from 'axios'

var users = [];

export default {
  name: 'Users',
  data: function() {
    return {
      message : "",
      users: users
    }
  },
  methods: {
    getAllUsers: function(){
      Axios.get("http://localhost:8081/test/users/get/all")
        .then(function(response) {
          for(var i = 0; i < response.data.data.length; i++){
            users.push(response.data.data[i].attributes)
      }
        })
        .catch(function (error){
          console.log(error)
        });
    }
  },
  created: function() {
    this.getAllUsers()
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
