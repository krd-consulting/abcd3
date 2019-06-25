<template>
    <div id="textBox">
        <el-row>
            <el-col :span="14">
                <label for="textArea" class="inputLabel">{{ field.label }}</label>
                <sup>{{ field.description }}</sup>
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
