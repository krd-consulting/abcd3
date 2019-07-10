<template>
    <div id="dropdown" class="tw-my-8">
        <el-row>
            <el-col :span="6">
                <label for="dropdown" class="inputLabel">{{ field.label }}</label>
            </el-col>
            
            <el-col :span="10">
                <el-select id="dropdown" v-model="value" placeholder="select">
                    <el-option v-for="item in field.choices" 
                        :key="item.id" 
                        :label="item.value" 
                        :value="item.value">
                    </el-option>
                </el-select>
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
