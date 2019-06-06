<template>
 <div id="inputOptions">

   <!--------TextBox---------->
   <div v-if="inputData.id === 0">
    <h1>{{ inputData.name }} Options</h1>
     <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
      <el-form-item label="Field Label">
        <el-input v-model="options.title"></el-input>
      </el-form-item>
      <el-form-item>
        <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
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
      
      <el-form-item>
        <el-button type="success" @click="submitOptions(options)">Set</el-button>
      </el-form-item>
    </el-form>
   </div>

   <!--------TextArea---------->
   <div v-if="inputData.id === 1">
    <h1>{{ inputData.name }} Options</h1>
     <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
      <el-form-item label="Field Label">
        <el-input v-model="options.title"></el-input>
      </el-form-item>
      <el-form-item>
        <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
      </el-form-item>
      <el-form-item label="Set Character Limit">
       <el-input-number v-model="options.setLength" :step="5" step-strictly></el-input-number>
      </el-form-item>
      <el-form-item>
        <el-button type="success" @click="submitOptions">Set</el-button>
      </el-form-item>
    </el-form>
   </div>

  <!---------Numeric--------->
   <div v-if="inputData.id === 2">
    <h1>{{ inputData.name }} Options</h1>
     <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
      <el-form-item label="Field Label">
        <el-input v-model="options.title"></el-input>
      </el-form-item>
      <el-form-item>
        <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
      </el-form-item>
      <el-form-item>
        <el-button type="success" @click="submitOptions">Set</el-button>
      </el-form-item>
    </el-form>
   </div>

   <!--------Dropdown---------->
   <div v-if="inputData.id === 3">
    <h1>{{ inputData.name }} Options</h1>
     <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
      <el-form-item label="Field Label">
        <el-input v-model="options.title"></el-input>
      </el-form-item>
      <el-form-item>
        <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
      </el-form-item>
      <el-form-item>
         <el-input-number v-model="options.dropdownNum" controls-position="right" @change="handleChange" :min="2" :max="10"></el-input-number>
      </el-form-item>

      <el-form-item>
        <el-button type="success" @click="submitOptions(options)">Set</el-button>
      </el-form-item>
    </el-form>
   </div>

   <!--------Radio---------->
   <div v-if="inputData.id === 4">
    <h1>{{ inputData.name }} Options</h1>
     <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
      <el-form-item label="Field Label">
        <el-input v-model="options.title"></el-input>
      </el-form-item>
      <el-form-item>
        <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
      </el-form-item>
      <el-form-item>
         <el-input-number v-model="options.radioNum" controls-position="right" @change="handleChange" :min="1" :max="10"></el-input-number>
      </el-form-item>
      <el-form-item>
        <el-button type="success" @click="submitOptions">Set</el-button>
      </el-form-item>
    </el-form>
   </div>

   <!--------Checkbox---------->
   <div v-if="inputData.id === 5">
    <h1>{{ inputData.name }} Options</h1>
     <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
      <el-form-item label="Field Label">
        <el-input v-model="options.title"></el-input>
      </el-form-item>
      <el-form-item>
        <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
      </el-form-item>
      <el-form-item>
         <el-input-number v-model="options.checkboxNum" controls-position="right" @change="handleChange" :min="1" :max="10"></el-input-number>
      </el-form-item>
      <el-form-item>
        <el-button type="success" @click="submitOptions">Set</el-button>
      </el-form-item>
    </el-form>
   </div>

   <!--------Date---------->
   <div v-if="inputData.id === 6">
    <h1>{{ inputData.name }} Options</h1>
     <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
      <el-form-item label="Field Label">
        <el-input v-model="options.title"></el-input>
      </el-form-item>
      <el-form-item>
        <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
      </el-form-item>
      <el-form-item>
        <el-button type="success" @click="submitOptions">Set</el-button>
      </el-form-item>
    </el-form>
   </div>
  
  <!--------Matrix---------->
  <div v-if="inputData.id === 7">
    <h1>{{ inputData.name }} Options</h1>
     <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
      <el-form-item label="Field Label">
        <el-input v-model="options.title"></el-input>
      </el-form-item>
      <el-form-item>
        <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
      </el-form-item>
      <el-form-item label="Number of Questions" >
         <el-input-number v-model="options.matrixQuestions"
            controls-position="right" 
            @change="handleChange" 
            :min="2">
          </el-input-number>
      </el-form-item>
      <el-form-item label="Number of Choices Per Question">
         <el-input-number v-model="options.matrixChoices"
            controls-position="right" 
            @change="handleChange" 
            :min="1" :max="10">
          </el-input-number>
      </el-form-item>
      <el-form-item>
        <el-button type="success" @click="submitOptions">Set</el-button>
      </el-form-item>
    </el-form>
   </div>

   <!--------Email---------->
   <div v-if="inputData.id === 8">
    <h1>{{ inputData.name }} Options</h1>
     <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
      <el-form-item label="Field Label">
        <el-input v-model="options.title"></el-input>
      </el-form-item>
      <el-form-item>
        <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
      </el-form-item>
      <el-form-item>
        <el-button type="success" @click="submitOptions">Set</el-button>
      </el-form-item>
    </el-form>
   </div>

   <!--------Address---------->
   <div v-if="inputData.id === 9">
    <h1>{{ inputData.name }} Options</h1>
     <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
      <el-form-item label="Field Label">
        <el-input v-model="options.title"></el-input>
      </el-form-item>
      <el-form-item>
        <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
      </el-form-item>
      <el-form-item>
        <el-button type="success" @click="submitOptions">Set</el-button>
      </el-form-item>
    </el-form>
   </div>

   <!--------Phone Number---------->
   <div v-if="inputData.id === 10">
    <h1>{{ inputData.name }} Options</h1>
     <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
      <el-form-item label="Field Label">
        <el-input v-model="options.title"></el-input>
      </el-form-item>
      <el-form-item>
        <el-switch v-model="options.required"></el-switch>
      </el-form-item>
      <el-form-item>
        <el-button type="success" @click="submitOptions">Set</el-button>
      </el-form-item>
    </el-form>
   </div>
 

 </div>
</template>

<script>
export default {
 name: 'inputOptions',
 data: () => {
  return {
   options: {
     title: '',
     required: false,
     reference: '',
     dropdownNum: 0,
     radioNum: 2,
     checkboxNum: 2,
     matrixQuestions: 2,
     matrixChoices: 5,
     setLength: 50,
    //  dropdownItems: {
    //   domains: [{
    //    key:1,
    //    value:''
    //   }]
    // }
   },
  }
 },
 props: {
   inputData: Object,
 },
 methods: {
  handleChange() {
    console.log('Doing the thing');
  },
  removeDomain(item) {
    var index = this.options.dropdownItems.domains.indexOf(item);
    if (index !== -1) {
      this.options.dropdownItems.domains.splice(index, 1);
    }
  },
  addDomain() {
    this.options.dropdownItems.domains.push({
      key: Date.now(),
      value: ''
    });
  },
  submitOptions(options) {
    this.$emit('outputData', this.options);
  }
 }
}
</script>

<style>

</style>
