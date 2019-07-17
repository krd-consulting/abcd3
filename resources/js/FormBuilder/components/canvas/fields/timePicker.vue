<template>
    <div>
        <el-row>
            <el-col :span="18">
                <label class="inputLabel">
                    <editable-text class="tw-cursor-pointer mouseOver" v-model="fieldLabel">
                        {{ fieldLabel }}
                    </editable-text>
                </label>
            </el-col>
            

            <el-time-select
                arrow-control
                v-model="timeSelection"
                :picker-options="{  
                    start: '01:00',
                    step: '00:15',
                    end: '24:45'
                }"
                placeholder="Pick a time">
            </el-time-select>
        </el-row>

            <el-switch 
                v-model="field.settings.required" 
                active-text="Required" 
                inactive-text="Optional"
                class="tw-float-right button-top">
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
