<template>
  <div id="FormList">
    <h1>Forms</h1>

    <el-container class="form-list">
      <el-main>
        <el-table 
          :data="tableData.filter(data => !search || data.form.toLowerCase().includes(search.toLowerCase()))" style="width: 120%">
          <el-table-column class="text-left" prop="form" label="Enabled Forms" width="180"></el-table-column>
          <el-table-column align="right" prop="date" label="Last Entry" width="180"></el-table-column>
          <el-table-column align="right">
            <template slot="header" slot-scope="{}">
              <span class="search-field">
                <el-input v-model="search" size="small" placeholder="Type to search" prefix-icon="el-icon-search"/>
              </span>
            </template>
            <template slot-scope="{}">
              <!-- Right aligned side panel -->
              <div v-click-outside="hide">
                <SidePanel>
                  <template slot="button-text"></template>
                  <h1 :data="tableData">Options: {{ tableData.form }}</h1>
                    <el-row :gutter="10">
                      <el-col :xs="8" :sm="6" :md="12" :lg="12" :xl="12">Lorem, ipsum dolor.</el-col>
                      <el-col :xs="8" :sm="6" :md="12" :lg="12" :xl="12">
                        <el-switch v-model="value3" active-text="on" inactive-text="off">Lorem, ipsum.</el-switch>
                      </el-col>
                  </el-row>
                  <el-row :gutter="10">
                      <el-col :xs="8" :sm="6" :md="12" :lg="12" :xl="12">Lorem ipsum dolor sit.</el-col>
                      <el-col :xs="8" :sm="6" :md="12" :lg="12" :xl="12">
                        <el-switch v-model="value3" active-text="on" inactive-text="off"></el-switch>
                      </el-col>
                  </el-row>
                  <el-row :gutter="10">
                      <el-col :xs="8" :sm="6" :md="12" :lg="12" :xl="12">Lorem ipsum dolor sit amet consectetur.</el-col>
                      <el-col :xs="8" :sm="6" :md="12" :lg="12" :xl="12">
                        <el-switch v-model="value3" active-text="on" inactive-text="off"></el-switch>
                      </el-col>
                  </el-row>
                  <el-row :gutter="10">
                      <el-col :xs="8" :sm="6" :md="12" :lg="12" :xl="12">Lorem ipsum, dolor sit amet consectetur adipisicing elit.</el-col>
                      <el-col :xs="8" :sm="6" :md="12" :lg="12" :xl="12">
                        <el-switch v-model="value3" active-text="on" inactive-text="off"></el-switch>
                      </el-col>
                  </el-row>
                </SidePanel>
              </div>
            </template>
          </el-table-column>
        </el-table>
      </el-main>
    </el-container>  
  </div>
</template>

<script>
import SidePanel from '@/components/SidePanel.vue'
import ClickOutside from 'vue-click-outside'

export default {
  name: 'FormList',
  props: {
    status: Boolean
  },
  components: {
    SidePanel
  },
  data() {
        return {
          tableData: [{
            date: '2016-05-03',
            options: '',
            form: 'Demographics'
          }, {
            date: '2016-05-03',
            options: '',
            form: 'MillerDuncan - ORS'
          }, {
            date: '2016-05-03',
            options: '',
            form: 'MillerDuncan - SRS'
          }, {
            date: '2016-05-03',
            options: '',
            form: 'Social Capital'
          }],
          search: '',
          scope: '',
          optionItems: {
            dashlet: '',
            quickAccess: '',
            disable: '',
            opened: false
          }
        }
      },
      methods: {
         hide() {
            this.opened = false
            //document.getElementById("options-menu").style.width = "0";
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  #FormList {
    /* font-size: 20px; */
  }
  .form-list {
    height: 500px;
    border: 1px solid #eee;
    margin: auto;
    width: 70%;
    padding: 12px;
  }
  .search-field {
    display: inline-block;
    width: 330px;

  }
  .grid-content {
    border-radius: 4px;
    min-height: 36px;
  }
  .el-col {
    padding-top: 50px;
    /* white-space: normal; */
    word-break: break-word;
    border-radius: 4px;
  }
</style>