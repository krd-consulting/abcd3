<template>
 <div id="inputOptions">

   <!--------TextBox---------->
   <div v-if="inputData.id === 0">
    <h1>{{ inputData.name }} Options</h1>
     <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
      <el-form-item label="Field Label">
        <el-input v-model="options.title"></el-input>
      </el-form-item>
      <el-form-item label="This Field is">
        <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
      </el-form-item>
      <el-form-item label="Set Character Limit">
          <el-switch v-model="options.isLimited" inactive-text="No Limit" active-text="Set Character Limit"></el-switch>
       <el-input-number :disabled="!options.isLimited" v-model="options.setLength" :step="5" step-strictly></el-input-number>
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
      <el-form-item label="This Field is">
        <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
      </el-form-item>
      <el-form-item label="Set Character Limit">
            <el-switch v-model="options.isLimited" inactive-text="No Limit" active-text="Set Character Limit"></el-switch>
            <el-input-number :disabled="!options.isLimited" v-model="options.setLength" :step="5" step-strictly></el-input-number>
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
      <el-form-item label="This Field is">
        <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
      </el-form-item>
      <el-form-item label="Set Default Value">
          <el-switch v-model="options.isLimited" inactive-text="No Default" active-text="Set Default"></el-switch>
          <el-input-number :disabled="!options.isLimited" v-model="options.defaultNum"></el-input-number>
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
      <el-form-item label="This Field is">
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
      <el-form-item label="This Field is">
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
      <el-form-item label="This Field is">
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
      <el-form-item label="This Field is">
        <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
      </el-form-item>
      <el-form-item label="Select By">
        <el-radio-group v-model="options.dateType" size="small">
          <el-radio-button label="day" ></el-radio-button>
          <el-radio-button label="extended"></el-radio-button>
          <el-radio-button label="range"></el-radio-button>
        </el-radio-group>
        <div v-if="options.dateType === 'day'">
          <span>Calendar Preferences</span><br>
          <el-switch v-model="options.daySelect1" inactive-text="No restriction" active-text="Only past dates"></el-switch>
          <el-switch v-model="options.daySelect2" inactive-text="No Quick menu" active-text="Quick menu"></el-switch>
          <el-switch v-model="options.daySelect3" inactive-text="No time" active-text="Include time"></el-switch>
        </div>
        <div v-if="options.dateType === 'extended'">
           <p>week?</p>
           <p>month?</p>
           <p>year?</p>
        </div>
        <div v-if="options.dateType === 'range'">
          <p>from this day to that day</p>
        </div>
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
      <el-form-item label="This Field is">
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

   <div v-if="inputData.id === 8">
       <h1>{{ inputData.name }} Options</h1>
       <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
            <el-form-item label="Section Title">
                <el-input v-model="options.sectionHeader"></el-input>
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
     title: 'Field Name',
     required: false,
     reference: '',
     defaultNum: 0,
     dropdownNum: 0,
     radioNum: 2,
     checkboxNum: 2,
     matrixQuestions: 2,
     matrixChoices: 5,
     isLimited: false,
     setLength: 50,
     sectionHeader: 'New Section',
     dateType: 'day',
     daySelect1: false,
     daySelect2: false,
     daySelect3: false,
   },
  }
 },
 props: {
   inputData: Object,
 },
 methods: {
  handleChange() {
    console.log('Doing the thing in input options');
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

<style scoped>
#inputOptions {
  margin-left: 15px;
  margin-right: 15px;
}
</style>
