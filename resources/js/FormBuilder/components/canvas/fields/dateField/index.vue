<template>
    <div id="datepciker">
        <el-collapse>
            <span class="inputLabel">{{ options.title }}</span><br>
            <el-collapse-item name="1">
                <template slot="title">
                    <div v-if="options.dateType === 'day'">
                        <div v-if="!options.daySelect1 && !options.daySelect2 && !options.daySelect3">
                            <calendar/>
                        </div>
                        <div v-if="options.daySelect1 && !options.daySelect2 && !options.daySelect3">
                            <calendar-past/>
                        </div>
                        <div v-if="!options.daySelect1 && options.daySelect2 && !options.daySelect3">
                            <calendar-menu/>
                        </div>
                        <div v-if="options.daySelect1 && options.daySelect2 && !options.daySelect3">
                            <calendar-past-menu/>
                        </div>
                        <div v-if="!options.daySelect1 && !options.daySelect2 && options.daySelect3">
                            <calendar-time/>
                        </div>
                        <div v-if="options.daySelect1 && !options.daySelect2 && options.daySelect3">
                            <calendar-past-time/>
                        </div>
                        <div v-if="!options.daySelect1 && options.daySelect2 && options.daySelect3">
                            <calendar-menu-time/>
                        </div>
                        <div v-if="options.daySelect1 && options.daySelect2 && options.daySelect3">
                            <calendar-menu-past-time/>
                        </div>
                    </div>

                    <div v-if="options.dateType === 'extended'">
                        <div>
                            <!-- week -->
                        </div>
                        <div>
                            <!-- month -->
                        </div>
                        <div>
                            <!-- year -->
                        </div>
                    </div>
                    <div v-if="options.dateType === 'range'"></div>

                    <!-- <el-date-picker v-if="value === 2" 
                        v-model="dateSelection" type="daterange"
                        range-separator="To"
                        start-placeholder="Start date"
                        end-placeholder="End date">
                    </el-date-picker> -->
                </template>
                <div>
                    <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
                        <el-form-item label="Field Label">
                            <el-col :span="6">
                                <el-input v-model="options.title"></el-input>
                            </el-col>
                        </el-form-item>
                        <el-form-item>
                            <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
                        </el-form-item>
                        <el-form-item label="Select By">
                            <el-radio-group v-model="options.dateType" size="medium">
                                <el-radio-button label="day" ></el-radio-button>
                                <el-radio-button label="extended"></el-radio-button>
                                <el-radio-button label="range"></el-radio-button>
                            </el-radio-group>
                            <div v-if="options.dateType === 'day'">
                                <span>Calendar Preferences</span><br>
                                <el-row>
                                    <el-switch v-model="options.daySelect1" inactive-text="No restriction" active-text="Only past dates"></el-switch>
                                </el-row>
                                <el-row>
                                    <el-switch v-model="options.daySelect2" inactive-text="No Quick menu" active-text="Quick menu"></el-switch>
                                </el-row>
                                <el-row>
                                    <el-switch v-model="options.daySelect3" inactive-text="No time" active-text="Include time"></el-switch>
                                </el-row>
                            </div>
                            <div v-if="options.dateType === 'extended'">
                                <p>week</p>
                                <p>month</p>
                                <p>year</p>
                            </div>
                            <div v-if="options.dateType === 'range'">
                                <p>from this day to that day</p>
                                <p>from this day/time to that day/time</p>
                                <p>from this week to that week</p>
                                <p>from this month to that month</p>
                                <p>quick menu</p>
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
import calendar from '@/FormBuilder/components/canvas/fields/dateField/calendar.vue'
import calendarPast from '@/FormBuilder/components/canvas/fields/dateField/calendarPast.vue'
import calendarMenu from '@/FormBuilder/components/canvas/fields/dateField/calendarMenu.vue'
import calendarPastMenu from '@/FormBuilder/components/canvas/fields/dateField/calendarPastMenu.vue'
import calendarTime from '@/FormBuilder/components/canvas/fields/dateField/calendarTime.vue'
import calendarPastTime from '@/FormBuilder/components/canvas/fields/dateField/calendarPastTime.vue'
import calendarMenuTime from '@/FormBuilder/components/canvas/fields/dateField/calendarMenuTime.vue'
import calendarMenuPastTime from '@/FormBuilder/components/canvas/fields/dateField/calendarMenuTime.vue'

export default {
    data: () => {
        return {
            dateLabel: '',
            dateSelection: '',
            value: 0,
        }
    },
    props: {
        options: {
            type: Array | Object,
            default: {}
        }
    },
    components: {
        calendar,
        calendarPast,
        calendarMenu,
        calendarPastMenu,
        calendarTime,
        calendarPastTime,
        calendarMenuTime,
        calendarMenuPastTime,
    }
}
</script>

<style>

</style>
