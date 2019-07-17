<template>
    <el-select 
        v-bind="$attrs" 
        v-on="$listeners" 
        :value="value" 
        @input="$emit('input', value)">
        <slot slot="prefix" name="prefix"></slot>
        <slot></slot>
    </el-select>
</template>
<script>
    export default {
        props: {
            value: ''
        },

        inheritAttrs: false
    }
</script>
