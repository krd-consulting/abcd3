<template>
  <div>
    <div class="tw-flex">
      <info-card
        icon="fas fa-calendar-plus"
        title="3 orders"
        description="Lorem ipsum dolor sit amet"
        text-class="tw-text-orange-base"
        bg-class="tw-bg-orange-lightest"
      ></info-card>
      <info-card
        icon="fas fa-copy"
        title="2 forms"
        description="Lorem ipsum dolor sit amet"
        text-class="tw-text-indigo-base"
        bg-class="tw-bg-indigo-lightest"
        class="tw-ml-5"
      ></info-card>
      <info-card
        icon="fas fa-link"
        title="15 links"
        description="Lorem ipsum dolor sit amet"
        text-class="tw-text-red-base"
        bg-class="tw-bg-red-lightest"
        class="tw-ml-5"
      ></info-card>
    </div>
    <div class="tw-mt-5 tw-flex tw--mx-5">
      <div class="tw-w-1/2 tw-px-5">
        <panel title="Notifications" :actions="[{icon: 'fas fa-plus', text: 'Add notifications'}]">
          <notification
            varient-color="indigo-base"
            title="Task description"
            description="Lorem ipsum dolor sit amet"
            icon="fas fa-check-square"
          ></notification>
          <notification
            varient-color="red-base"
            title="Alert description"
            description="Lorem ipsum dolor sit amet"
            icon="fas fa-bell"
            class="tw-mt-2"
          ></notification>
          <notification
            varient-color="indigo-base"
            title="Task description"
            description="Lorem ipsum dolor sit amet"
            icon="fas fa-check-square"
            class="tw-mt-2"
          ></notification>
          <notification
            varient-color="orange-base"
            title="Task description"
            description="Lorem ipsum dolor sit amet"
            icon="fas fa-check-square"
            class="tw-mt-2"
          ></notification>
          <notification
            varient-color="orange-base"
            title="Task description"
            description="Lorem ipsum dolor sit amet"
            icon="fas fa-check-square"
            class="tw-mt-2"
          ></notification>
        </panel>
      </div>
      <div class="tw-w-1/2 tw-px-5">
        <panel title="Activity list" :actions="[{icon: 'fas fa-plus', text: 'Add activity'}]">
          <activity
            date="2020-05-22 21:30"
            title="Activity Title"
            description="Description - Lorem ipsum dolor sit amet."
            v-for="index in [1, 2, 3, 4]"
            :key="index"
            :separation="index > 1"
          ></activity>
        </panel>
      </div>
    </div>
    <div class="tw-mt-5">
      <panel title="Attachments" :actions="[{icon: 'fas fa-plus', text: 'Add file'}]">
        <file name="File name" v-for="index in [1, 2, 3, 4, 5]" :key="index" class="tw-mr-5"></file>
      </panel>
    </div>
  </div>
</template>

<script>
import Notification from "./Notification";
import Activity from "./Activity";
import File from "./File";

export default {
  name: "Summary",
  components: {
    Notification,
    Activity,
    File
  }
};
</script>
