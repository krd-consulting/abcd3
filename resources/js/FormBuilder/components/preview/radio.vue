<template>
    <div id="radio">
        <label for="radioGroup" class="inputLabel">{{ field.label }}</label><br>
        <sup>{{ field.description }}</sup>
        <el-radio-group id="radioGroup" 
            class="tw-mr-8" 
            v-model="select" 
            v-for="item in field.options.responses" 
            :key="item.id">
                <el-radio :label="item.text"></el-radio>
        </el-radio-group>
    </div>
</template>

<script>
export default {
    data() {
        return {
            select: ''
        }
    },
    props: { 
        field: Object
    },
}
</script>

<style>
ul {
  list-style-type: none;
}
</style>
