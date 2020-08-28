import Request from '@/api/TeamRequest';

export function index() {
    this.request.setFields({
        params: {...this.params}
    });

    this.request.retrieve().then(response => {
        this.teams = response.data;
        this.fields = response.fields;
        this.total = response.meta.total;
    });
}

export function profile(team = this.$route.params.team) {
    this.request.setFields({
        params: {...this.params}
    });

    this.request.show(team).then((response) => {
        this.team = response.data;
    });
}

export function createTeam() {
    this.create.active = true;
}

export function editTeam(team) {
    this.edit.team = team;

    this.edit.active = true;
}

export function confirmDelete(team) {
    this.$confirm('Are you sure you want to delete this team?', 'Delete Team', {
        confirmButtonText: 'Delete',
        cancelButtonText: 'Wait, no!',
        type: 'warning'
    }).then(() => {
        this.deleteTeam(team)
            .then(() => {
                this.retrieve();

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
}

export function deleteTeam(team) {
    let request = new Request();

    return request.destroy(team);
}

export function disable(team) {
    let data = {
        active: false
    };

    let request = new Request(data);

    return request.update(team);
}

export function confirmDisable(team) {
    this.$confirm('Are you sure you want to disable this team?', 'Disable Team', {
        confirmButtonText: 'Disable',
        cancelButtonText: 'Wait, no!',
        type: 'warning'
    }).then(() => {
        this.disable(team)
            .then(() => {
                this.retrieve();

                this.$message({
                    type: 'success',
                    message: 'Team is disabled.'
                });
            })
            .catch((error) => {
                this.$message({
                    type: 'error',
                    message: error.message
                });
            });
    })
}

export function enable(team) {
    let data = {
        active: true
    };

    let request = new Request(data);

    return request.update(team);
}

export function confirmEnable(team) {
    this.$confirm('Are you sure you want to enable this team?', 'Enable Team', {
        confirmButtonText: 'Enable',
        cancelButtonText: 'Wait, no!',
        type: 'warning'
    }).then(() => {
        this.enable(team)
            .then(() => {
                this.retrieve();

                this.$message({
                    type: 'success',
                    message: 'Team is enabled.'
                });
            })
            .catch((error) => {
                this.$message({
                    type: 'error',
                    message: error.message
                });
            });
    })
}

export default {
    index,
    profile,
    createTeam,
    editTeam,
    confirmDelete,
    deleteTeam,
    confirmDisable,
    disable,
    confirmEnable,
    enable
}
