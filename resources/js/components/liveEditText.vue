<template>
    <span @click="edit">
        <input
            v-model="newValue"
            v-if="editing"
            ref="edit"
            @blur="exit"
            @change="save"
            type="text"
            :size="newValue.length">
        <span v-if="!editing">{{ value }}</span>
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
                this.newValue = this.value;
                this.editing = true;

                this.$nextTick(() => {
                    this.$refs.edit.focus();
                });
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
