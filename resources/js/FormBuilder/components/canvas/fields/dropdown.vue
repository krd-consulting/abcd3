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
                    v-if="dropItem != ''" 
                    type="text" 
                    size="mini" 
                    @click="removeChoice(dropItem)">
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
                <el-col :span="10">
                    <label for="newItem">Add Item <el-button class="tw-ml-2" type="text" @click="addItem">Add</el-button></label>
                    <el-input id="newItem" v-model="itemText">
                    </el-input>
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
            dropItem: '',
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
            get() { return this.field.label; },
            set(label) {
                const fieldCopy = _.clone(this.field);
                fieldCopy.label = label;
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
            get(){ return this.field.choices.value},
            // set(dropItem){
            //     const fieldCopy = _.clone(this.field);
            //     fieldCopy.choices.value = dropItem;
            //     this.choices = fieldCopy.choices;

            //     this.$forceUpdate();
            // }
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
        },
        removeChoice(item, index) {
            var index = this.choices.indexOf(item);

            if (index !== -1) {
                this.choices.splice(index, 1);
                this.$store.commit('UPDATE_FIELD', this.field)
            }

            this.$forceUpdate();
        },
        updateChoiceValue(value) {
            // var index = this.choices.indexOf(value);
            const fieldCopy = _.clone(this.field);
            fieldCopy.choices.value = value;
            this.choices = fieldCopy.choices;

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


