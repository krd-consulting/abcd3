<template>
 <div id="inputOptions">

   <!--------TextBox---------->
   <div v-if="inputData.id === 0">
    <h1>{{ inputData.name }} options</h1>
     <el-form label-position="top" ref="fieldData" :model="fieldData" @submit.native.prevent>
      <el-form-item label="Field Label">
        <el-input v-model="fieldData.label"></el-input>
      </el-form-item>
      <el-form-item label="Field Description">
        <el-input v-model="fieldData.description"></el-input>
      </el-form-item>
      <el-form-item label="This Field is">
        <el-switch v-model="fieldData.required" active-text="Required" inactive-text="Optional"></el-switch>
      </el-form-item>
      <el-form-item label="Set Character Limit">
          <el-switch v-model="fieldData.settings.isLimited" inactive-text="No Limit" active-text="Set Character Limit"></el-switch>
       <el-input-number :disabled="!fieldData.settings.isLimited" v-model="fieldData.settings.max" :step="5" step-strictly></el-input-number>
      </el-form-item>
      <!-- <el-form-item label="Field Refers To:">
        <el-select v-model="fieldData.reference">
         <el-option label="Itself" value="itself"></el-option>
          <el-option label="A field within this form" value="internalField"></el-option>
          <el-option label="Volunteer" value="volunteer"></el-option>
          <el-option label="Client" value="client"></el-option>
          <el-option label="Staff" value="staff"></el-option>
        </el-select>
        <div v-if="fieldData.reference === 'internalField'">
         <p>Do some stuff</p>
        </div>
        <div v-if="fieldData.reference === 'volunteer'">
         <p>Do some other stuff</p>
        </div>
        <div v-if="fieldData.reference === 'client'">
         <p>Do something else</p>
        </div>
        <div v-if="fieldData.reference === 'staff'">
         <p>What are our references really?</p>
        </div>
      </el-form-item> -->
      
      <el-form-item>
        <el-button type="success" @click="submitfieldData(fieldData)">Set</el-button>
      </el-form-item>
    </el-form>
   </div>

   <!--------TextArea---------->
   <div v-if="inputData.id === 1">
    <h1>{{ inputData.name }} Settings</h1>
     <el-form label-position="top" ref="fieldData" :model="fieldData" @submit.native.prevent>
      <el-form-item label="Field Label">
        <el-input v-model="fieldData.label"></el-input>
      </el-form-item>
      <el-form-item label="Field Description">
        <el-input v-model="fieldData.description"></el-input>
      </el-form-item>
      <el-form-item label="This Field is">
        <el-switch v-model="fieldData.required" active-text="Required" inactive-text="Optional"></el-switch>
      </el-form-item>
      <el-form-item label="Set Character Limit">
            <el-switch v-model="fieldData.settings.isLimited" inactive-text="No Limit" active-text="Set Character Limit"></el-switch>
            <el-input-number :disabled="!fieldData.settings.isLimited" v-model="fieldData.settings.max" :step="5" step-strictly></el-input-number>
      </el-form-item>
      <el-form-item>
        <el-button type="success" @click="submitfieldData">Set</el-button>
      </el-form-item>
    </el-form>
   </div>

  <!---------Numeric--------->
   <div v-if="inputData.id === 2">
    <h1>{{ inputData.name }} Settings</h1>
     <el-form label-position="top" ref="fieldData" :model="fieldData" @submit.native.prevent>
      <el-form-item label="Field Label">
        <el-input v-model="fieldData.label"></el-input>
      </el-form-item>
      <el-form-item label="Field Description">
        <el-input v-model="fieldData.description"></el-input>
      </el-form-item>
      <el-form-item label="This Field is">
        <el-switch v-model="fieldData.required" active-text="Required" inactive-text="Optional"></el-switch>
      </el-form-item>
      <el-form-item label="Set Default Value">
          <el-switch v-model="fieldData.isLimited" inactive-text="No Default" active-text="Set Default"></el-switch>
          <el-input-number :disabled="!fieldData.isLimited" v-model="fieldData.defaultNum"></el-input-number>
      </el-form-item>
      <el-form-item>
        <el-button type="success" @click="submitfieldData">Set</el-button>
      </el-form-item>
    </el-form>
   </div>

   <!--------Dropdown---------->
   <div v-if="inputData.id === 3">
    <h1>{{ inputData.name }} Settings</h1>
     <el-form label-position="top" ref="fieldData" :model="fieldData" @submit.native.prevent>
      <el-form-item label="Field Label">
        <el-input v-model="fieldData.label"></el-input>
      </el-form-item>
      <el-form-item label="Field Description">
        <el-input v-model="fieldData.description"></el-input>
      </el-form-item>
      <el-form-item label="This Field is">
        <el-switch v-model="fieldData.required" active-text="Required" inactive-text="Optional"></el-switch>
      </el-form-item>
      <el-form-item>
         <el-input-number v-model="fieldData.settings.dropdownNum" controls-position="right" @change="handleChange" :min="2" :max="10"></el-input-number>
      </el-form-item>

      <el-form-item>
        <el-button type="success" @click="submitfieldData(fieldData)">Set</el-button>
      </el-form-item>
    </el-form>
   </div>

   <!--------Radio---------->
   <div v-if="inputData.id === 4">
    <h1>{{ inputData.name }} Settings</h1>
     <el-form label-position="top" ref="fieldData" :model="fieldData" @submit.native.prevent>
      <el-form-item label="Field Label">
        <el-input v-model="fieldData.label"></el-input>
      </el-form-item>
      <el-form-item label="Field Description">
        <el-input v-model="fieldData.description"></el-input>
      </el-form-item>
      <el-form-item label="This Field is">
        <el-switch v-model="fieldData.required" active-text="Required" inactive-text="Optional"></el-switch>
      </el-form-item>
      <el-form-item>
         <el-input-number v-model="fieldData.settings.radioNum" controls-position="right" @change="handleChange" :min="1" :max="10"></el-input-number>
      </el-form-item>
      <el-form-item>
        <el-button type="success" @click="submitfieldData">Set</el-button>
      </el-form-item>
    </el-form>
   </div>

   <!--------Checkbox---------->
   <div v-if="inputData.id === 5">
    <h1>{{ inputData.name }} Settings</h1>
     <el-form label-position="top" ref="fieldData" :model="fieldData" @submit.native.prevent>
      <el-form-item label="Field Label">
        <el-input v-model="fieldData.label"></el-input>
      </el-form-item>
      <el-form-item label="Field Description">
        <el-input v-model="fieldData.description"></el-input>
      </el-form-item>
      <el-form-item label="This Field is">
        <el-switch v-model="fieldData.required" active-text="Required" inactive-text="Optional"></el-switch>
      </el-form-item>
      <el-form-item>
         <el-input-number v-model="fieldData.settings.checkboxNum" controls-position="right" @change="handleChange" :min="1" :max="10"></el-input-number>
      </el-form-item>
      <el-form-item>
        <el-button type="success" @click="submitfieldData">Set</el-button>
      </el-form-item>
    </el-form>
   </div>

   <!--------Date---------->
   <div v-if="inputData.id === 6">
    <h1>{{ inputData.name }} Settings</h1>
     <el-form label-position="top" ref="fieldData" :model="fieldData" @submit.native.prevent>
      <el-form-item label="Field Label">
        <el-input v-model="fieldData.label"></el-input>
      </el-form-item>
      <el-form-item label="Field Description">
        <el-input v-model="fieldData.description"></el-input>
      </el-form-item>
      <el-form-item label="This Field is">
        <el-switch v-model="fieldData.required" active-text="Required" inactive-text="Optional"></el-switch>
      </el-form-item>
      <el-form-item label="Calendar Preferences">
        <el-row>
          <el-switch v-model="fieldData.settings.past_only" active-text="Only allow up to current day"></el-switch>
        </el-row>
        <el-row>
          <el-switch v-model="fieldData.settings.quick_menu" active-text="Quick menu"></el-switch>
        </el-row>
        <el-row>
          <el-switch v-model="fieldData.settings.include_time" active-text="Include time"></el-switch>
        </el-row>
        <el-row>
          <el-switch v-model="fieldData.settings.date_range" active-text="Date Range"></el-switch>
        </el-row>
      </el-form-item>
      <el-form-item>
        <el-button type="success" @click="submitfieldData">Set</el-button>
      </el-form-item>
    </el-form>
   </div>
  
  <!-------- Time Picker ---------->
   <div v-if="inputData.id === 7">
       <h1>{{ inputData.name }} Settings</h1>
       <el-form label-position="top" ref="fieldData" :model="fieldData" @submit.native.prevent>
            <el-form-item label="Field Label">
                <el-input v-model="fieldData.label"></el-input>
            </el-form-item>
            <el-form-item label="Field Description">
              <el-input v-model="fieldData.description"></el-input>
            </el-form-item>
             <el-form-item label="This Field is">
              <el-switch v-model="fieldData.required" active-text="Required" inactive-text="Optional"></el-switch>
            </el-form-item>
            <el-form-item>
                <el-button type="success" @click="submitfieldData">Set</el-button>
            </el-form-item>
       </el-form>
   </div>

  <!--------Matrix---------->
  <div v-if="inputData.id === 8">
    <h1>{{ inputData.name }} Settings</h1>
     <el-form label-position="top" ref="fieldData" :model="fieldData" @submit.native.prevent>
      <el-form-item label="Field Label">
        <el-input v-model="fieldData.label"></el-input>
      </el-form-item>
      <el-form-item label="Field Description">
        <el-input v-model="fieldData.description"></el-input>
      </el-form-item>
      <el-form-item label="This Field is">
        <el-switch v-model="fieldData.required" active-text="Required" inactive-text="Optional"></el-switch>
      </el-form-item>
      <el-form-item label="Number of Questions" >
         <el-input-number v-model="fieldData.settings.matrix_questions"
            controls-position="right" 
            @change="handleChange" 
            :min="1">
          </el-input-number>
      </el-form-item>
      <el-form-item label="Number of Choices Per Question">
         <el-input-number v-model="fieldData.settings.matrix_choices"
            controls-position="right" 
            @change="handleChange" 
            :min="1" :max="10">
          </el-input-number>
      </el-form-item>
      <el-form-item>
        <el-button type="success" @click="submitfieldData">Set</el-button>
      </el-form-item>
    </el-form>
   </div>

  <!-------- File Upload ---------->
    <div v-if="inputData.id === 9">
       <h1>{{ inputData.name }} Settings</h1>
       <el-form label-position="top" ref="fieldData" :model="fieldData" @submit.native.prevent>
            <el-form-item label="Field Label">
                <el-input v-model="fieldData.label"></el-input>
            </el-form-item>
            <el-form-item label="Field Description">
              <el-input v-model="fieldData.description"></el-input>
            </el-form-item>
            <el-form-item label="This Field is">
              <el-switch v-model="fieldData.required" active-text="Required" inactive-text="Optional"></el-switch>
            </el-form-item>
            <el-form-item>
                <el-button type="success" @click="submitfieldData">Set</el-button>
            </el-form-item>
       </el-form>
   </div>

  <!-------- Section Divider ---------->
    <div v-if="inputData.id === 10">
       <h1>{{ inputData.name }} Settings</h1>
       <el-form label-position="top" ref="fieldData" :model="fieldData" @submit.native.prevent>
            <el-form-item label="Section label">
                <el-input v-model="fieldData.label"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="success" @click="submitfieldData">Set</el-button>
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
   fieldData: {
     label: 'Field Name',
     description: '',
     reference: '',
     settings: {
        required: false,
        defaultNum: 0,
        dropdownNum: 0,
        radioNum: 2,
        checkboxNum: 2,
        matrix_questions: 2,
        matrix_choices: 5,
        isLimited: false,
        max: 50,
        past_only: false,
        future_only: false,
        quick_menu: false,
        include_time: false,
        date_range: false,
    }
     
   },
  }
 },
 props: {
   inputData: Object,
 },
 methods: {
  handleChange() {
    console.log('Doing the thing in inputOptions');
  },
  submitfieldData(fieldData) {
    this.$emit('outputData', this.fieldData);
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
