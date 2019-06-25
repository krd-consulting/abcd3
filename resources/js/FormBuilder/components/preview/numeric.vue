<template>
    <div id="numeric">
        <label for="numfield" class="inputLabel">{{ field.label }}</label><br>
        <sup>{{ field.description }}</sup>
        
        <el-input-number id="numfield" v-model="value"></el-input-number>
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
