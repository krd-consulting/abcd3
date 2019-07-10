<template>
    <div id="textBox" class="tw-my-8">
        <el-row>
            <el-col :span="6">
                <label for="textArea" class="inputLabel">{{ field.label }}</label>
            </el-col>

            <el-col :span="10">
                <el-input id="textArea"  
                    type="textarea" 
                    :rows="3" 
                    :maxlength="field.settings.setLength" 
                    show-word-limit 
                    placeholder="Your text here" 
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
}
</script>

<style>

</style>
