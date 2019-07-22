<template>
    <div>
        <br>
        <el-divider>

            <span>
                <editable-text class="tw-cursor-pointer mouseOver" v-model="fieldLabel">
                    {{ fieldLabel }}
                </editable-text>
                
            </span>

        </el-divider>

        <slot></slot>
    </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    data() {
        return {}
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
        field: {
            get() { return this.fieldData; },
            set(field) { 
                console.log('field edited');
                this.$emit('update', field); 
            }
        },

        fieldLabel: {
            get() { return this.field.title; },
            set(title) { 
                console.log('field label edited');

                const fieldCopy = _.clone(this.field);

                fieldCopy.title = title;

                this.field = fieldCopy;
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

