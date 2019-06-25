<template>
    <div id="dropdown">
         <p>This is a Radio Componment!</p>


        <!-- <label for="radioGroup" class="inputLabel">{{ inputFieldData.label }}</label><br>
        <sup>{{ inputFieldData.description }}</sup>
        <el-radio-group id="radioGroup" v-for="item in radioList" :key="item.value">
            <el-radio v-model="item.value" :label="item.value">{{ item.value }}</el-radio>
        </el-radio-group>

        <el-collapse>
            <el-collapse-item>
                <template slot="title">
                    <el-button icon="el-icon-edit">Field Options</el-button>
                </template>
                <div class="tw-flex tw-inline-block tw-w-full">
                    <div class="tw-float-left">
                            
                        <el-row class="tw-my-6">
                            <label for="label">Field Label</label>
                            <el-col :span="20">
                                <el-input id="label" v-model="inputFieldData.label"></el-input>
                            </el-col>
                        </el-row>
                        <el-row class="tw-my-6">
                            <el-col :span="20">
                                <label for="description">Field Description</label>
                                <el-input id="description" v-model="inputFieldData.description"></el-input>
                            </el-col>
                        </el-row>
                        <el-row class="tw-my-6">
                            <label for="switch" class="tw-mb-4">This field is</label><br>
                            <el-switch id="switch" v-model="inputFieldData.required" active-text="Required" inactive-text="Optional"></el-switch>
                        </el-row>
                    </div>

                     <div class="tw-float-right tw-mx-20 tw-my-6">
                        <form @submit.prevent="addItem">
                            <el-col :span="16">
                                <label for="newItem">Add a new item to the list</label>
                                <el-input id="newItem" v-model="itemText"></el-input>
                                <el-button type="success" @click="addItem">Add</el-button>
                            </el-col>
                        </form>
                    </div>   
                    
                    <div class="tw-float-right tw-mx-20 tw-my-6">
                        <h3>Radio List Items</h3>
                        <el-row v-for="item in radioList" :key="item.id">
                            <editable-text class="cursor-text float-left" @input="showField" v-model="item.value">{{ item.value }}</editable-text>
                            <el-button class="float-right pr-15" type="text" size="mini" @click="removeItem(item)">Remove</el-button>
                        </el-row>
                    </div>

                </div>

                <slot></slot>
            </el-collapse-item>
        </el-collapse> -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            select: []
        }
    },
    props: { 
        field: Object
    },
}
</script>

<style>
ul {
  list-style-type: none;
}
</style>
