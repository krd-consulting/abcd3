<template>
    <div id="numeric" class="tw-my-8">
        <el-row>
            <el-col :span="6">
                <label for="numfield" class="tw-block tw-text-right tw-mr-1">{{ field.title }}</label>
            </el-col>

            <el-col :span="10">
                <el-input-number 
                    v-if="limit"
                    id="numfield" 
                    :value="value"
                    @input="$emit('input', $event)"
                    :required="isRequired">
                </el-input-number>
                <el-input-number 
                    v-else
                    id="numfield" 
                    :value="value"
                    @input="$emit('input', $event)"
                    :required="isRequired">
                </el-input-number>
            </el-col>
        </el-row>
    </div>
</template>

<script>
export default {
    data() {
        return {}
    },
    props: { 
        field: Object,
        value: ''
    },
    computed: {
        useDefault: {
            get() { return this.field.settings.defaultNum }
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
