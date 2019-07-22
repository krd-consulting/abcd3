<template>
    <div>
        <el-row>
            <el-col :span="6">
                <label class="inputLabel">
                    <editable-text class="tw-cursor-pointer mouseOver" v-model="fieldLabel">
                        {{ fieldLabel }}
                    </editable-text>
                </label>
            

                <el-time-select v-if="exactTime === false"
                    arrow-control
                    v-model="timeSelection"
                    :picker-options="{  
                        start: '01:00',
                        step: '00:15',
                        end: '24:45'
                    }"
                    placeholder="Pick a time">
                </el-time-select>
                
                <el-time-picker v-else
                    arrow-control
                    v-model="timeSelection"
                    placeholder="Pick a time">
                </el-time-picker>
                
            </el-col>
        </el-row>

            <el-switch 
                v-model="field.settings.required" 
                active-text="Required" 
                inactive-text="Optional"
                class="tw-float-right tw-mr-48 button-top">
            </el-switch>

            <div class="footer">
                <slot></slot>
            </div>
        
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
            // set(exactTime) { 
            //     const fieldCopy = _.clone(this.field);
            //     fieldCopy.settings.exact_time = exactTime;
            //     this.field = fieldCopy;
            // }
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
.button-top {
    position: absolute;
    top: 30px;;
    right: 10px;
}
.footer{
    position: absolute;
    bottom: 0;
    right: 10px;
}
</style>
