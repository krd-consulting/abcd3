<template>
    <div id="textField">
        <el-row>
            <el-col :span="10">
                <label for="text" class="inputLabel">{{ field.label }}</label><br>
                <sup>{{ field.description }}</sup>
                <el-input id="text" v-model="value"></el-input>
            </el-col>
        </el-row>
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
