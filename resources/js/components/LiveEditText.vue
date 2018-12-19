<template>
    <span @click="edit">
        <input v-model="newValue" @blur="exit" @change="save" ref="edit" v-show="editing" type="text">
        <span v-show="!editing">{{ value }}</span>
    </span>
</template>
<script>
    export default {
        props: {
            value: String
        },

        data() {
            return {
                editing: false,
                newValue: this.value
            }
        },

        methods: {
            edit() {
                this.editing = true;
                this.$refs.edit.focus();
            },
            exit() {
                this.editing = false;
            },
            save() {
                this.$emit('change', this.newValue);
                this.exit();
            }
        }
    }
</script>
