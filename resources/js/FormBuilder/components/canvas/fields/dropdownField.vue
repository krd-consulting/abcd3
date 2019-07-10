<template>
    <div id="dropdown">
        <label class="inputLabel">
            <editable-text class="tw-cursor-pointer mouseOver" v-model="fieldLabel">
                {{ fieldLabel }}
            </editable-text>
        </label>
        <el-select id="dropdown" v-model="dropItem" placeholder="select">
            <el-option v-for="item in choices" :key="item.id" :label="item.value" :value="item.value"></el-option>
        </el-select>
        <div class="tw-float-right">
            <editable-text 
                class="tw-cursor-pointer mouseOver" 
                v-model="dropItem"
                @input="updateChoiceValue(dropItem)">
                {{ dropItem }}
            </editable-text>
            <el-button v-if="dropItem != ''" class="float-right pr-15" type="text" size="mini" @click="removeChoice(value)">Remove Item</el-button>
        </div>
        
        <form @submit.prevent="addItem" class="tw-mt-4">
            <el-row>
                <el-col :span="12">
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
            set(value){
                const fieldValue = _.clone(this.field);
                fieldValue.choices.value = value;
                this.field = fieldValue;
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
        },
        // loadItem() {
        //     this.field.choices.push({
        //          id: this.nextItem++, value: 'item ' + this.nextItem
        //     })
        //     this.$store.commit('UPDATE_FIELD', this.field)
        // },
        removeChoice(item) {
            var index = this.choices.indexOf(item);

            if (index !== -1) {
                this.choices.splice(index, 1);
                this.$store.commit('UPDATE_FIELD', this.field)
            }

            this.$forceUpdate();
        },
        updateChoiceValue(value) {
            var index = this.choices.indexOf(value);
            const fieldCopy = _.clone(this.field);
            fieldCopy.choices[index].value = value;
            this.choices = fieldCopy.choices;
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
</style>


