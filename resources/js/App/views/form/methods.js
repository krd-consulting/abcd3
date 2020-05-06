import Request from '@/api/FormRequest';

export function index() {
    this.request.setFields({
        params: {...this.params}
    });

    this.request.retrieve().then(response => {
        this.forms = response.data;
        this.total = response.meta.total;
    });
}

export function editForm(form) {
    this.edit.form = form;

    this.edit.active = true;
}

export function confirmDelete(form) {
    this.$confirm('Are you sure you want to delete this Form?', 'Delete Form', {
        confirmButtonText: 'Delete',
        cancelButtonText: 'Wait, no!',
        type: 'warning'
    }).then(() => {
        this.deleteForm(form)
            .then(() => {
                this.retrieve();

                this.$message({
                    type: 'success',
                    message: 'Form was deleted.'
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

export function deleteForm(form) {
    let request = new Request();

    return request.destroy(form);
}

export function disable(form) {
    let data = {
        active: false
    };

    let request = new Request(data);

    return request.update(form);
}

export function confirmDisable(form) {
    this.$confirm('Are you sure you want to disable this form?', 'Disable Form', {
        confirmButtonText: 'Disable',
        cancelButtonText: 'Wait, no!',
        type: 'warning'
    }).then(() => {
        this.disable(form)
            .then(() => {
                this.retrieve();

                this.$message({
                    type: 'success',
                    message: 'Form is disabled.'
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

export function enable(form) {
    let data = {
        active: true
    };

    let request = new Request(data);

    return request.update(form);
}

export function confirmEnable(form) {
    this.$confirm('Are you sure you want to enable this form?', 'Enable Form', {
        confirmButtonText: 'Enable',
        cancelButtonText: 'Wait, no!',
        type: 'warning'
    }).then(() => {
        this.enable(form)
            .then(() => {
                this.retrieve();

                this.$message({
                    type: 'success',
                    message: 'Form is enabled.'
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
    editForm,
    confirmDelete,
    deleteForm,
    confirmDisable,
    disable,
    confirmEnable,
    enable
}
