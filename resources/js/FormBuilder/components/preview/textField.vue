<template>
    <div id="textField" class="tw-my-8">
        <el-row>
            <el-col :span="6">
                <label for="text" class="inputLabel">{{ field.label }}</label>
            </el-col>
            <el-col :span="10">
                <el-input id="text"
                    v-if="limit"
                    show-word-limit  
                    v-model="value" 
                    :required="isRequired"
                    :maxlength="max">
                </el-input>
                <el-input id="text"
                    v-else 
                    v-model="value" 
                    :required="isRequired">
                </el-input>
            </el-col>
        </el-row>
    </div>
</template>

<script>
export default {
    data() {
        return {
            value: '',
        }
    },
    props: { 
        field: {
            type: Array | Object,
            default: {}
        }
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
