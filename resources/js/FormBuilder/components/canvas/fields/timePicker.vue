<template>
    <div>
        <slot></slot>
        
        <div class="tw-inline-flex tw-my-1">
            <label class="tw-flex-1">
                <editable-text class="tw-cursor-pointer mouseOver tw-mr-1" v-model="fieldLabel">
                    {{ fieldLabel }}
                </editable-text>
            </label>
            <div class="tw-flex-none">
                <el-time-select v-if="exactTime === false"
                    arrow-control
                    :picker-options="{  
                        start: '01:00',
                        step: '00:15',
                        end: '24:45'
                    }"
                    placeholder=" ">
                </el-time-select>
                
                <el-time-picker v-else
                    arrow-control
                    v-model="timeSelection"
                    placeholder=" ">
                </el-time-picker>
                
            </div>
        </div>

            <el-switch 
                v-model="required" 
                active-text="Required" 
                inactive-text="Optional"
                class="tw-float-right switch-position">
            </el-switch>
        
    </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    data: () => {
        return {
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
            get() { return this.field.title; },
            set(title) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.title = title;
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

        exactTime: {
            get() { return this.field.settings.exact_time; },
            set(exactTime) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.settings.exact_time = exactTime;
                this.field = fieldCopy;
            }
        },

        required: {
            get() { return this.field.settings.required; },
            set(required) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.settings.required = required;
                this.field = fieldCopy;
            }
        }
    },
}
</script>

<style scoped>
.mouseOver:hover {
    color: #409EFF;
    text-decoration: underline;
    font-size: 110%;
}
.switch-position {
    position: relative;
    top: 15px;
    right: 40px;
}
.footer{
    position: absolute;
    bottom: 0;
    right: 10px;
}
</style>
