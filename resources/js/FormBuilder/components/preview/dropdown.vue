<template>
    <div id="dropdown">
        <label for="dropdown" class="inputLabel">{{ field.label }}</label><br>
        <sup>{{ field.description }}</sup>
        <el-select id="dropdown" v-model="value" placeholder="select">
            <el-option v-for="item in field.choices" 
                :key="item.id" 
                :label="item.text" 
                :value="item.text">
            </el-option>
        </el-select>
    </div>
</template>

<script>
export default {
    data() {
        return {
            value: ''
        }
    },
    props: { 
        field: Object
    },
}
</script>

<style>

</style>
