<template>
 <div id="preview">
   <el-container>
     <el-header>
       <el-menu :default-active="$route.path" 
          class="w-full" background-color="#eef1f6" active-text-color="#409EFF" 
          mode="horizontal" @select="handleSelect" router>
          <el-menu-item default-active index="/forms/create" class="font-bold focus:font-extrabold">Form Builder</el-menu-item>
          <el-menu-item index="/forms/create/preview" class="font-bold focus:font-extrabold">Preview Form</el-menu-item>
          <el-menu-item index="/forms" class="dock-right font-bold focus:font-extrabold" @click="buildForm">Finish and Build!</el-menu-item>
        </el-menu>
     </el-header>
     <el-main>
       <h1>This is a completed form!</h1>
     </el-main>
   </el-container>
 </div>
</template>

<script>
export default {

}
</script>

<style scoped>

</style>
