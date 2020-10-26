<template>
  <div>
    <grid
      title="Forms"
      :items="forms"
      :fields="fields"
      :page.sync="params.page"
      :sortBy.sync="params.sortBy"
      :ascending.sync="params.ascending"
      :per-page="params.perPage"
      :search-terms.sync="params.search"
      :loading="false"
      @params-change="retrieve('teams', $route.params.team);"
      has-add
      :has-edit="false"
      :has-bookmark="false"
      :total="total"
      :extra-actions="[{icon: 'fas fa-eye', label: 'Show entries'}, {icon: 'fas fa-plus', label: 'Add new entry'}]"
      @extra-action="handleExtraAction"
    >
    </grid>
  </div>
</template>

<script>
    import Grid from "@/components/extendable/grid";

    import Request from '@/api/EntityTypeFormsRequest';

    export default {
        components: {
            Grid,
        },

        data() {
            return {
                request: new Request({}),
                forms: [],
                fields: [],
                params: {
                    ascending: true,
                    sortBy: 'name',
                    page: 1,
                    perPage: 10,
                    search: ''
                },
                total: 0,
            }
        },

        methods: {
            retrieve(entity, id) {
                this.request.setFields({
                    params: {...this.params}
                });

                this.request.retrieve(entity, id).then((response) => {
                    this.forms = response.data;
                    this.fields = response.fields;
                    this.total = response.meta.total;
                });
            },

            handleExtraAction({itemId, actionIndex}) {
              if (actionIndex === 1) {
                this.$router.push(`/forms/${itemId}/new`);
              }
            }
        },

        created() {
            this.retrieve('teams', this.$route.params.team);
        },
    }
</script>
