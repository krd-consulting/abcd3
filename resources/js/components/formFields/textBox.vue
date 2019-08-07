<template>
    <div id="textBox" class="tw-my-8">
        <el-row>
            <el-col :span="6">
                <label for="textArea" class="tw-block tw-text-right tw-mr-1">{{ field.title }}</label>
            </el-col>

            <el-col :span="10">
                <el-input id="textArea"  
                    type="textarea" 
                    v-if="limit"
                    :autosize="{ minRows: 3, maxRows: 5}"
                    :maxlength="max" 
                    show-word-limit 
                    placeholder=" " 
                    v-model="value">
                </el-input>
                <el-input id="textArea"  
                    type="textarea" 
                    v-else
                    :autosize="{ minRows: 3, maxRows: 6}" 
                    placeholder=" " 
                    v-model="value">
                </el-input>
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
    computed: {
        max: {
            get() { return this.field.settings.max }
        },
        isRequired: {
            get() { return this.field.settings.required }
        },
        limit: {
            get() { return this.field.settings.isLimited }
        }
    }
}
</script>

<style>

</style>
