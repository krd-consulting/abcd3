<template>
  <div class="tw-mt-5 tw-flex tw--mx-5">
    <div class="tw-w-1/2 tw-px-5">
      <panel :title="`Diets (${diets.length})`">
        <div
          v-for="diet in diets"
          :key="diet"
          class="tw-rounded-lg tw-py-2 tw-px-5 tw-border tw-border-indigo-base tw-flex tw-items-center tw-justify-between tw-mt-3"
        >
          <div class="tw-text-sm">{{ diet }}</div>
          <i class="fas fa-times tw-text-indigo-base tw-cursor-pointer"></i>
        </div>
      </panel>
    </div>
    <div class="tw-w-1/2 tw-px-5">
      <panel :title="`Special requests (${specialRequests.length})`">
        <div
          v-for="specialRequest in specialRequests"
          :key="specialRequest"
          class="tw-rounded-lg tw-py-2 tw-px-5 tw-border tw-border-indigo-base tw-flex tw-items-center tw-justify-between tw-mt-3"
        >
          <div class="tw-text-sm">{{ specialRequest }}</div>
          <i class="fas fa-times tw-text-indigo-base tw-cursor-pointer"></i>
        </div>
      </panel>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProfileDiets",
  data() {
    return {
      diets: ["Diet name 1", "Diet name 2"],
      specialRequests: ["Special request name1"]
    };
  }
};
</script>
