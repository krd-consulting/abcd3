<template>
    <div id="textarea">
        <el-row>
            <el-col :span="10">
                <label for="textArea" class="inputLabel">{{ inputFieldData.label }}</label>
                <sup>{{ inputFieldData.description }}</sup>
                <el-input id="textArea" 
                    v-if="inputFieldData.options.isLimited" 
                    type="textarea" 
                    :rows="2" 
                    :maxlength="inputFieldData.options.setLength" 
                    show-word-limit 
                    placeholder="Your text here" 
                    v-model="customArea">
                </el-input>
                <el-input id="textArea" 
                    v-else type="textarea" 
                    :rows="2" 
                    placeholder="Your text here" 
                    v-model="customArea">
                </el-input>
            </el-col>
        </el-row>
        <el-collapse>
            <el-collapse-item name="1">
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
                            <el-switch id="switch" 
                                v-model="inputFieldData.required" 
                                active-text="Required" 
                                inactive-text="Optional">
                            </el-switch>
                        </el-row>
                    </div>

                    <div class="tw-float-right tw-mx-20 tw-my-6">
                        <label for="charLimit">Set Character Limit</label><br>
                        <el-switch id="charLimit" 
                            v-model="inputFieldData.options.isLimited" 
                            inactive-text="No Limit"
                            active-text="Set Character Limit">
                        </el-switch><br>
                        <el-input-number class="tw-my-6" 
                            :disabled="!inputFieldData.options.isLimited" 
                            v-model="inputFieldData.options.setLength" 
                            :step="5" :min="0" 
                            step-strictly>
                        </el-input-number>

                        <el-row class="tw-my-6">
                        <label for="reference">Field Refers To:</label><br>
                          <el-select id="reference" v-model="inputFieldData.options.reference">
                              <el-option label="Itself" value="itself"></el-option>
                              <el-option label="A field within this form" value="internalField"></el-option>
                              <el-option label="Volunteer" value="volunteer"></el-option>
                              <el-option label="Client" value="client"></el-option>
                              <el-option label="Staff" value="staff"></el-option>
                          </el-select>
                    </el-row>
                    <el-row>
                        <div v-if="inputFieldData.options.reference === 'internalField'">
                              <p>Do some stuff</p>
                          </div>
                          <div v-if="inputFieldData.options.reference === 'volunteer'">
                              <p>Do some other stuff</p>
                          </div>
                          <div v-if="inputFieldData.options.reference === 'client'">
                              <p>Do some thing</p>
                          </div>
                          <div v-if="inputFieldData.options.reference === 'staff'">
                              <p>Do some other thing</p>
                          </div>
                    </el-row>

                    </div>
                </div>
                <slot></slot>
            </el-collapse-item>
        </el-collapse>
    </div>
</template>

<script>
export default {
    data() {
        return {
            customArea: '',
            setLength: 50,
            inputFieldData: []
        }
    },
    props: {
        fieldData: {
            type: Array | Object,
            default: {
                label: 'Text Area',
            }
        }
    },
    created() {
        this.inputFieldData = _.clone(this.fieldData)
    },
}
</script>

<style>

</style>
