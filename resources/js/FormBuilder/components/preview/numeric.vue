<template>
    <div id="numeric" class="tw-my-8">
        <el-row>
            <el-col :span="6">
                <label for="numfield" class="inputLabel">{{ field.label }}</label>
            </el-col>

            <el-col :span="10">
                <el-input-number id="numfield" v-model="value"></el-input-number>
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
