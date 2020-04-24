<template>
    <div id="dropdown" class="tw-my-8">
        <el-row>
            <el-col :span="6">
                <label for="dropdown" class="tw-block tw-text-right tw-mr-1">{{ field.title }}</label>
            </el-col>

            <el-col :span="10">
                <el-select
                    id="dropdown"
                    v-model="value"
                    @input="$emit('input', $event)"
                    filterable
                    placeholder=" ">
                    <el-option v-for="choice in field.choices"
                        :key="choice"
                        :label="choice"
                        :value="choice">
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
