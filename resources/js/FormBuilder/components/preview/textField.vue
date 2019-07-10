<template>
    <div id="textField" class="tw-my-8">
        <el-row>
            <el-col :span="6">
                <label for="text" class="inputLabel">{{ field.label }}</label>
            </el-col>
            <el-col :span="10">
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
