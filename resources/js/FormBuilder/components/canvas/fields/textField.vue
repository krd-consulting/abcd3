<template>
  <div id="Textfield">
    <el-row>
        <el-col :span="8">
            <label for="label" class="inputLabel">{{ field.label }}</label><br>
            <sup>{{ field.settingsDescription }}</sup>
            <el-input v-if="field.settings.isLimited"
                id="label"
                type="text" 
                :maxlength="field.settings.max" 
                placeholder="Your text here" 
                v-model="value" 
                show-word-limit>
            </el-input>
            <el-input v-else 
                type="text" 
                placeholder="Your text here" 
                v-model="value">
            </el-input>
        </el-col>
    </el-row>
    
    <el-collapse>
        <el-collapse-item name="1">
          <template slot="title">
                <el-button icon="el-icon-edit">Field field</el-button>
          </template>
              <div class="tw-flex tw-inline-block tw-w-full">
                    <div class="tw-float-left">
                            
                        <el-row class="tw-my-6">
                            <label for="label">Field Label</label>
                            <el-col :span="20">
                                <el-input id="label" v-model="field.label"></el-input>
                            </el-col>
                        </el-row>
                        <el-row class="tw-my-6">
                            <el-col :span="20">
                                <label for="description">Field Subtext</label>
                                <el-input id="description" v-model="field.settingsDescription"></el-input>
                            </el-col>
                        </el-row>
                        <el-row class="tw-my-6">
                            <label for="switch" class="tw-mb-4">This field is</label><br>
                            <el-switch id="switch" 
                                v-model="field.settings.required" 
                                active-text="Required" 
                                inactive-text="Optional">
                            </el-switch>
                        </el-row>
                    </div>

                    <div class="tw-float-right tw-mx-20 tw-my-6">
                        <label for="charLimit">Set Character Limit</label><br>
                            <el-switch id="charLimit" 
                                v-model="field.settings.isLimited" 
                                inactive-text="No Limit" 
                                active-text="Limit">
                            </el-switch><br>
                            <el-input-number class="tw-my-6" :disabled="!field.settings.isLimited" v-model="field.settings.max" :step="5" :min="0" step-strictly></el-input-number>
                        
                    <!-- <el-row class="tw-my-6">
                        <label for="reference">field Refers To:</label><br>
                          <el-select id="reference" v-model="field.settings.reference">
                              <el-option label="Itself" value="itself"></el-option>
                              <el-option label="A field within this form" value="internalfield"></el-option>
                              <el-option label="Volunteer" value="volunteer"></el-option>
                              <el-option label="Client" value="client"></el-option>
                              <el-option label="Staff" value="staff"></el-option>
                          </el-select>
                    </el-row>
                    <el-row>
                        <div v-if="field.settings.reference === 'internalfield'">
                              <p>Do some stuff</p>
                          </div>
                          <div v-if="field.settings.reference === 'volunteer'">
                              <p>Do some other stuff</p>
                          </div>
                          <div v-if="field.settings.reference === 'client'">
                              <p>Do some thing</p>
                          </div>
                          <div v-if="field.settings.reference === 'staff'">
                              <p>Do some other thing</p>
                          </div>
                    </el-row> -->
                        
                  </div>
              </div>
            <slot></slot>
        </el-collapse-item>
    </el-collapse>
  </div>
</template>

<script>
export default {
    name: 'Textfield',
    data() {
        return {
            value: '',
            field: []
        }
    },
    props: {
        fieldData: {
            type: Array | Object,
            default: {
                label: 'Text Field'
            }
        }
    },
    created() {
        this.field = _.clone(this.fieldData)
    }
}
</script>

<style>
</style>
