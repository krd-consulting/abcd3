<template>
    <div id="textarea">
        <el-collapse>
            <span class="inputLabel">{{ options.title }}</span><br>
            <el-collapse-item name="1">
                <template slot="title">
                    <el-input type="textarea" :rows="2" :maxlength="options.setLength" show-word-limit placeholder="Your text here" v-model="customArea"></el-input>
                </template>
                <div>
                    <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
                        <el-form-item label="Field Label">
                            <el-input v-model="options.title"></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
                        </el-form-item>
                        <el-form-item label="Set Character Limit">
                            <el-input-number v-model="options.setLength" :step="5" step-strictly></el-input-number>
                        </el-form-item>
                    </el-form>
                </div>
                <slot></slot>
            </el-collapse-item>
        </el-collapse>
    </div>
</template>

<script>
export default {
    data() {
        return {
            customArea: '',
            setLength: 50,
        }
    },

    props: {
        options: {
            type: Array | Object,
            default: {
                title: 'Text Area',
                required: false,
                reference: '',
                dropdownNum: 2,
                radioNum: 2,
                checkboxNum: 2,
                matrixQuestions: 2,
                matrixChoices: 5,
                setLength: 50,
                dropdownItems: {
                    domains: [{
                        key:1,
                        value:''
                    }]
                }
            }
        }
    },
}
</script>

<style>

</style>
