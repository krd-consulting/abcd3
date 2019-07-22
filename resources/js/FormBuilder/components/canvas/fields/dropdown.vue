<template>
    <div id="dropdown">
        <div>
            <el-col :span="18">
                <label class="inputLabel">
                    <editable-text class="tw-cursor-pointer mouseOver" v-model="fieldLabel">
                        {{ fieldLabel }}
                    </editable-text>
                </label>
            </el-col>
            <div class="tw-inline-block">
                <el-select id="dropdown" v-model="dropItem" placeholder="select">
                    <el-option v-for="(item, index) in choices" :key="index" :label="item.value" :value="item.value"></el-option>
                </el-select>
            </div>

            <div class="tw-inline-block">
                <editable-text 
                    class="tw-cursor-pointer mouseOver" 
                    v-model="dropItem"
                    @input="updateChoiceValue($event)">
                    {{ dropItem }}
                </editable-text>
                <el-button 
                    v-if="dropItem != null" 
                    type="text" 
                    size="mini" 
                    @click="removeChoice(dropItem, index)">
                            Remove Item
                </el-button>
            </div>

        </div>

        <el-switch 
            v-model="field.settings.required" 
            active-text="Required" 
            inactive-text="Optional"
            class="tw-float-right tw-mr-48 button-top">
        </el-switch>
        
        <form @submit.prevent="addItem" class="tw-mt-4">
            <el-row> 
                <el-col :span="6" class="tw-float-left">
                    <label for="add-item">Add a new Item</label>
                    <el-input id="add-item" v-model="itemText"></el-input>
                    <el-tooltip content="Alternatively, you can press enter after typing in this field to add items to the list">
                        <el-button type="text" @click="addItem">Add</el-button>
                    </el-tooltip>
                </el-col>
            </el-row>
        </form>

        <slot></slot>
    </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    data() {
        return {
            itemText: '',
            value: '',
            nextItem: 0,
        }
    },
    components: {
        EditableText
    },
    props: {
        fieldData: {
            type: Array | Object,
            default: {}
        }
    },
    computed: {
        field: {
            get() { return this.fieldData; },
            set(field) { this.$emit('update', field); }
        },

        fieldLabel: {
            get() { return this.field.title; },
            set(title) {
                const fieldCopy = _.clone(this.field);
                fieldCopy.title = title;
                this.field = fieldCopy;
            }
        },

        choices: {
            get() { return this.field.choices },
            set(choices) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.choices = choices;
                this.field = fieldCopy;
            }
        },

        dropItem: {
            get(){ return this.choices.value},
            set(value){
                const choicesCopy = _.clone(this.choices);
                choicesCopy.value = value;
                this.choices = choicesCopy;

                this.$forceUpdate();
            }
        },
    },
    methods: {
        addItem() {
            const choicesCopy = _.clone(this.choices);

            choicesCopy.push({
                id: this.nextItem++, value: this.itemText
            });

            this.choices = choicesCopy;
            this.itemText = ''
            this.$forceUpdate();
        },
        removeChoice(item, index) {
            // var index = this.choices.indexOf(item);

            if (index !== -1) {
                this.choices.splice(index, 1);
                this.$store.commit('UPDATE_FIELD', this.field)
            }
            this.dropItem = '';
            this.$forceUpdate();
        },
        updateChoiceValue(value, index) {
            // var index = this.choices.indexOf(value);
            const fieldCopy = _.clone(this.field);
            fieldCopy.choices[index].value = value;
            this.choices = fieldCopy.choices;
            this.dropItem = value;
            this.$forceUpdate();
        }
    }
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
</style>


