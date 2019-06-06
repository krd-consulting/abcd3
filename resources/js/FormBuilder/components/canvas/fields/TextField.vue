<template>
  <div id="textbox">
    <el-collapse>
      <span class="inputLabel">{{ options.title }}</span><br>
        <el-collapse-item name="1">
          <template slot="title">
              <el-input type="text" v-model="customField"></el-input>
          </template>
              <div><br>
              <h1>hey</h1>
                  <el-form label-position="top" ref="options" :model="options" :rules="rules" @submit.native.prevent>
                      <el-form-item label="Field Label">
                          <el-input v-model="options.title"></el-input>
                      </el-form-item>
                      <el-form-item label="This field is:" prop="customField">
                          <el-switch v-model="options.required" active-text="Required" inactive-text="Optional" 
                              @click="required = !required"></el-switch>
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
            title: 'Text Field',
            setLength: 50,
            customField: ''
        }
    },
    props: {
        options: {
            type: Array | Object,
            default: {
                title: 'Text Field',
                required: false,
                reference: '',
                dropdownNum: 2,
                radioNum: 2,
                checkboxNum: 2,
                matrixQuestions: 2,
                matrixChoices: 5,
                setLength: 50,
                dropdownItems: {
                    domains: [{
                        key:1,
                        value:''
                    }]
                }
            }
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
