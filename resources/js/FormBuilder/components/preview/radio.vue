<template>
    <div id="radio" class="tw-my-8">
        <el-row>
            <el-col :span="6">
                <label for="radioGroup" class="inputLabel">{{ field.label }}</label>
            </el-col>

            <el-col :span="10">
                <el-radio-group id="radioGroup" 
                    class="tw-mr-8" 
                    v-model="select" 
                    v-for="item in field.choices" 
                    :key="item.id">
                        <el-radio :label="item.value"></el-radio>
                </el-radio-group>
            </el-col>
        </el-row>

        <br>
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
