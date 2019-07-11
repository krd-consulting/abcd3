<template>
    <div>
        <el-row>

            <label class="inputLabel">
                <editable-text class="tw-cursor-pointer mouseOver" v-model="fieldLabel">
                    {{ fieldLabel }}
                </editable-text>
            </label>

            <el-time-picker
                arrow-control
                v-model="timeSelection"
                :picker-options="{selectableRange: '18:30:00 - 20:30:00'}"
                placeholder="Pick a time">
            </el-time-picker>

            <slot></slot>
        </el-row>
    </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    data: () => {
        return {
            timeSelection: '',
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
    // created() {
    //     this.field = _.clone(this.fieldData)
    // },
}
</script>

<style scoped>
.mouseOver:hover {
    color: #409EFF;
    text-decoration: underline;
    font-size: 110%;
}
</style>
