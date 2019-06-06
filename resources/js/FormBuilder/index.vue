<template>
  <div id="asd">
  <!-- TODO: Integrate into global NavBar -->
    <!-- <div id="nav" class="bg-gray-200">
      <router-link to="/">Forms</router-link> |
      <router-link to="/NewForm">New Form</router-link> | 
      <router-link to="/Preview">Preview Form</router-link>  <span><i class="el-icon-back"></i> this will be replaced by the global nav menu</span>
    </div> -->
    <router-view/>
  </div>
</template>

<style scoped>

#asd {
  font-family: 'Inter UI', Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}
#nav {
  padding: 30px;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
}
.el-card {
  margin: 5px;
}
</style>
