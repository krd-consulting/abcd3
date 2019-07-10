<template>
    <div class="tw-my-8">
        <el-row>
            <el-col :span="6">
                <label for="check" class="inputLabel">{{ field.label }}</label>
            </el-col>
            <el-col :span="10">
                <el-checkbox-group id="check" 
                    class="tw-h-8"
                    v-for="item in field.choices" 
                    :key="item.id"
                    v-model="select">

                        <el-checkbox :label="item.value" class="tw-my-2 tw-ml-8 tw-text-lg"></el-checkbox>

                </el-checkbox-group>
            </el-col>
            
        </el-row>
    </div>
</template>

<script>
export default {
    data() {
        return {
            select: []
        }
    },
    props: { 
        field: Object
    },
}
</script>

<style>

</style>
