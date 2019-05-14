<template>
    <div>
        <edit-team
            :active.sync="edit.active"
            :team-id="team.id"
            @update="retrieve"/>

        <resource-profile 
            @edit="editTeam(team)" 
            @delete="confirmDelete(team)">
            <template v-slot:header>
                {{ team.name }}
            </template>
            <template v-slot:subheader>
                {{ team.description }}
            </template>
        </resource-profile>
    </div>
</template>
<script>
    import TeamRequest from '../api/TeamRequest';

    import ResourceProfile from '../components/AppResourceProfile';
    import EditTeam from './AppTeamEdit';

    export default {
        components: {
            ResourceProfile,
            EditTeam
        },

        data() {
            return {
                team: {
                    name: '',
                    description: ''
                },
                edit: {
                    active: false,
                },
                recordTypes: [],
                request: new TeamRequest({}),
                total: 0,
                type: {
                    name: ''
                },
            }
        },

        methods: {
            retrieve(team = this.$route.params.team) {
                this.request.setFields({
                    params: {...this.params}
                });

                this.request.show(team).then((response) => {
                    this.team = response.data;
                });
            },

            confirmDelete(team) {
                this.$confirm('Are you sure you want to delete this team?', 'Delete Team', {
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.deleteTeam(team)
                        .then(() => {
                            this.$router.push('/teams');

                            this.$message({
                                type: 'success',
                                message: 'Team was deleted.'
                            });
                        })
                        .catch((error) => {
                            this.$message({
                                type: 'error',
                                message: error.message
                            });
                        });
                })
            },

            editTeam(team) {
                this.edit.team = team;

                this.edit.active = true;
            },

            deleteTeam(team) {
                let request = new TeamRequest({});

                return request.destroy(team.id);
            },
        },

        created() {
            this.retrieve();
        },

        beforeRouteUpdate (to, from, next) {
            this.retrieve(to.params.team);
            next();
        }

    }
</script>
