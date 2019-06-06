<template>
    <div id="address">
        <span class="inputLabel">{{ options.title }}</span><br>
        <el-input type="text" placeholder="123 address" v-model="addressfields"></el-input>
        <slot></slot>
    </div>
</template>

<script>
export default {
    data: () => {
        return {

        }
    },
    props: {
        options: {
            type: Array | Object,
            default: {
                title: 'Address',
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
