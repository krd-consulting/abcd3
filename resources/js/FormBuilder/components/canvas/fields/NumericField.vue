<template>
    <div id="numeric">
        <el-collapse>
            <span class="inputLabel">{{ options.title }}</span><br>
            <el-collapse-item name="1">
                <template slot="title">
                    <el-input-number placeholder="" v-model="numfield"></el-input-number>
                </template>
                <div>
                    <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
                        <el-form-item label="Field Label">
                            <el-input v-model="options.title"></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
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
            numfield: '',
            // options: {
            //     title: 'Number',
            //     required: false,
            //     reference: '',
            //     setLength: 50,
            //     dropdownItems: {
            //     domains: [{
            //             key:1,
            //             value:''
            //         }]
            //     }
            // },
        }
    },

    props: {
        options: {
            type: Array | Object,
            default: {
                title: 'Number Field',
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
                // title: 'Text Field',
                // isRequired: false,
                // reference: '',
                // charCount: 50,
                // dropdownItems: {
                //         domains: [{
                //         key:1,
                //         value:''
                //     }]
                // }
            }
        }
    },
}
</script>

<style>

</style>
