<template>
  <div id="textbox">
    <el-collapse>
      <span class="inputLabel">{{ options.title }}</span><br>
        <el-collapse-item name="1">
          <template slot="title">
                <el-input v-if="options.isLimited" type="text" :rows="2" :maxlength="options.setLength" placeholder="Your text here" v-model="customField"></el-input>
                <el-input v-else type="text" :rows="2" placeholder="Your text here" v-model="customField"></el-input>
          </template>
              <div><br>
                  <el-form label-position="top" ref="options" :model="options" :rules="rules" @submit.native.prevent>
                      <el-form-item label="Field Label">
                          <el-col :span="6">
                              <el-input v-model="options.title"></el-input>
                          </el-col>
                          
                      </el-form-item>
                      <el-form-item label="This field is ">
                          <el-switch v-model="options.required" active-text="Required" inactive-text="Optional" 
                              @click="required = !required"></el-switch>
                      </el-form-item>
                      <el-form-item label="Set Character Limit">
                            <el-switch v-model="options.isLimited" inactive-text="No Limit" active-text="Set Character Limit"></el-switch><br>
                            <el-input-number :disabled="!options.isLimited" v-model="options.setLength" :step="5" :min="0" step-strictly></el-input-number>
                        </el-form-item>
                      <el-form-item label="Field Refers To:">
                          <el-select v-model="options.reference">
                              <el-option label="Itself" value="itself"></el-option>
                              <el-option label="A field within this form" value="internalField"></el-option>
                              <el-option label="Volunteer" value="volunteer"></el-option>
                              <el-option label="Client" value="client"></el-option>
                              <el-option label="Staff" value="staff"></el-option>
                          </el-select>
                          <div v-if="options.reference === 'internalField'">
                              <p>Do some stuff</p>
                          </div>
                          <div v-if="options.reference === 'volunteer'">
                              <p>Do some other stuff</p>
                          </div>
                          <div v-if="options.reference === 'client'">
                              <p>Do something else</p>
                          </div>
                          <div v-if="options.reference === 'staff'">
                              <p>What are our references really?</p>
                          </div>
                      </el-form-item>
                  </el-form>
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
            setLength: 50,
            customField: ''
        }
    },
    props: {
        options: {
            type: Array | Object,
            default: {}
        }
    },
    computed: {
      rules() {
        return { 
          customField: [
            {required: this.isRequired, message: 'Please make an entry', trigger: 'blur' },
          ]
        }
      }
    }
}
</script>

<style>

</style>
