import Request from '@/api/ProgramRequest';

export function index() {
    this.request.setFields({
        params: {...this.params}
    });

    this.request.retrieve().then(response => {
        this.programs = response.data;
        this.fields = response.fields;
        this.total = response.meta.total;
    });
}

export function profile(program = this.$route.params.program) {
    this.request.setFields({
        params: {...this.params}
    });

    this.request.show(program).then((response) => {
        this.program = response.data;
    });
}

export function createProgram() {
    this.create.active = true;
}

export function editProgram(program) {
    this.edit.program = program;

    this.edit.active = true;
}

export function confirmDelete(program) {
    this.$confirm('Are you sure you want to delete this program?', 'Delete Program', {
        confirmButtonText: 'Delete',
        cancelButtonText: 'Wait, no!',
        type: 'warning'
    }).then(() => {
        this.deleteProgram(program)
            .then(() => {
                this.retrieve();

                this.$message({
                    type: 'success',
                    message: 'Program was deleted.'
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

export function deleteProgram(program) {
    let request = new Request();

    return request.destroy(program);
}

export function disable(program) {
    let data = {
        active: false
    };

    let request = new Request(data);

    return request.update(program);
}

export function confirmDisable(program) {
    this.$confirm('Are you sure you want to disable this program?', 'Disable Program', {
        confirmButtonText: 'Disable',
        cancelButtonText: 'Wait, no!',
        type: 'warning'
    }).then(() => {
        this.disable(program)
            .then(() => {
                this.retrieve();

                this.$message({
                    type: 'success',
                    message: 'Program is disabled.'
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

export function enable(program) {
    let data = {
        active: true
    };

    let request = new Request(data);

    return request.update(program);
}

export function confirmEnable(program) {
    this.$confirm('Are you sure you want to enable this program?', 'Enable Program', {
        confirmButtonText: 'Enable',
        cancelButtonText: 'Wait, no!',
        type: 'warning'
    }).then(() => {
        this.enable(program)
            .then(() => {
                this.retrieve();

                this.$message({
                    type: 'success',
                    message: 'Program is enabled.'
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
    createProgram,
    editProgram,
    confirmDelete,
    deleteProgram,
    confirmDisable,
    disable,
    confirmEnable,
    enable
}
