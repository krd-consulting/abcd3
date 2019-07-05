<template>
    <div id="numeric">
        <label class="inputLabel">
            <editable-text class="tw-cursor-pointer mouseOver" v-model="fieldLabel">
                {{ fieldLabel }}
            </editable-text>
        </label>
        <el-input-number id="numfield" v-if="field.settings.isLimited" 
            v-model="field.settings.defaultNum">
        </el-input-number>
        <el-input-number id="numfield" 
            v-else 
            v-model="num">
        </el-input-number>

        <slot></slot>
    </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    name: 'numeric',
    data() {
        return {
            num: 0,
        }
    },
    props: {
        fieldData: {
            type: Array | Object,
            default: {}
        }
    },
    components: {
        EditableText
    },
    computed: {
        fieldLabel: {
            get() { return this.field.label; },
            set(label) { 
                console.log('field label edited');

                const fieldCopy = _.clone(this.field);

                fieldCopy.label = label;

                this.field = fieldCopy;
            }
        },

        field: {
            get() { return this.fieldData; },
            set(field) { 
                console.log('field edited');
                this.$emit('update', field); 
            }
        },
    },
}
</script>

<style scoped>
.mouseOver:hover {
    color: #409EFF;
    text-decoration: underline;
    font-size: 110%;
}
</style>
