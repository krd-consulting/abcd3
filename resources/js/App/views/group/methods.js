import Request from '@/api/GroupRequest';

export function index() {
    this.request.setFields({
        params: {...this.params}
    });

    this.request.retrieve().then(response => {
        this.groups = response.data;
        this.fields = response.fields;
        this.total = response.meta.total;
    });
}

export function profile() {
    this.request.setFields({
        params: {...this.params}
    });

    this.request.show(this.$route.params.group).then((response) => {
        this.group = response.data;
    });
}

export function createGroup() {
    this.create.active = true;
}

export function editGroup(group) {
    this.edit.group = group;

    this.edit.active = true;
}

export function confirmDelete(group) {
    this.$confirm('Are you sure you want to delete this group?', 'Delete Group', {
        confirmButtonText: 'Delete',
        cancelButtonText: 'Wait, no!',
        type: 'warning'
    }).then(() => {
        this.deleteGroup(group)
            .then(() => {
                this.retrieve();

                this.$message({
                    type: 'success',
                    message: 'Group was deleted.'
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

export function deleteGroup(group) {
    let request = new Request();

    return request.destroy(group);
}

export function disable(group) {
    let data = {
        active: false
    };

    let request = new Request(data);

    return request.update(group);
}

export function confirmDisable(group) {
    this.$confirm('Are you sure you want to disable this group?', 'Disable Group', {
        confirmButtonText: 'Disable',
        cancelButtonText: 'Wait, no!',
        type: 'warning'
    }).then(() => {
        this.disable(group)
            .then(() => {
                this.retrieve();

                this.$message({
                    type: 'success',
                    message: 'Group is disabled.'
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

export function enable(group) {
    let data = {
        active: true
    };

    let request = new Request(data);

    return request.update(group);
}

export function confirmEnable(group) {
    this.$confirm('Are you sure you want to enable this group?', 'Enable Group', {
        confirmButtonText: 'Enable',
        cancelButtonText: 'Wait, no!',
        type: 'warning'
    }).then(() => {
        this.enable(group)
            .then(() => {
                this.retrieve();

                this.$message({
                    type: 'success',
                    message: 'Group is enabled.'
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
    createGroup,
    editGroup,
    confirmDelete,
    deleteGroup,
    confirmDisable,
    disable,
    confirmEnable,
    enable
}
