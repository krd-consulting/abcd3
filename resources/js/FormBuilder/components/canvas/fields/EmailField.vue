<template>
    <div id="email">
        <span class="inputLabel">{{ options.title }}</span><br>
        <el-input type="email" placeholder="example@email.com" v-model="emailfield"></el-input>
        <slot></slot>
    </div>
</template>

<script>
export default {
    data: () => {

    },
    props: {
        options: {
            type: Array | Object,
            default: {
                title: 'Email',
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
