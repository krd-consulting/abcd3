import Request from '@/api/RecordRequest';

export function index(recordType = this.$route.params.recordType) {
    this.loading = true;

    this.request.setFields({
        params: {...this.params}
    });

    this.request.retrieve(recordType).then((response) => {
        this.fields = response.fields;
        this.records = response.data;
        this.total = response.meta.total;
        this.type = response.record_type;

        this.loading = false;
    });

}

export function profile() {
    this.request.setFields({
        params: {...this.params}
    });

    this.request.show(this.$route.params.recordType, this.$route.params.record).then((response) => {


        this.record = response.data;
        this.fields = response.data.fields;
    });
}

export function createRecord() {
    this.create.active = true;
}

export function editRecord(record) {
    this.edit.record = record;

    this.edit.active = true;
}

export function confirmDelete(recordType, record) {
    this.$confirm('Are you sure you want to archive this record?', 'Archive Record', {
        confirmButtonText: 'Archive',
        cancelButtonText: 'Wait, no!',
        type: 'warning'
    }).then(() => {
        this.deleteRecord(recordType, record)
            .then(() => {
                this.retrieve();

                this.$message({
                    type: 'success',
                    message: 'Record was deleted.'
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

export function deleteRecord(recordType, record) {
    let request = new Request({});

    return request.destroy(recordType, record);
}

export function disableRecord(recordType, record) {
    let newRecordData = {
        active: false
    };

    let request = new Request(newRecordData);

    return request.update(recordType, record);
}

export function confirmDisable(recordType, record) {
    this.$confirm('Are you sure you want to disable this record?', 'Disable Record', {
        confirmButtonText: 'Disable',
        cancelButtonText: 'Wait, no!',
        type: 'warning'
    }).then(() => {
        this.disableRecord(recordType, record)
            .then(() => {
                this.retrieve();

                this.$message({
                    type: 'success',
                    message: 'Record is disabled.'
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

export function enableRecord(recordType, record) {
    let newRecordData = {
        active: true
    };

    let request = new Request(newRecordData);

    return request.update(recordType, record);
}

export function confirmEnable(recordType, record) {
    this.$confirm('Are you sure you want to enable this record?', 'Enable Record', {
        confirmButtonText: 'Enable',
        cancelButtonText: 'Wait, no!',
        type: 'warning'
    }).then(() => {
        this.enableRecord(recordType, record)
            .then(() => {
                this.retrieve();

                this.$message({
                    type: 'success',
                    message: 'Record is enabled.'
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
    createRecord,
    editRecord,
    confirmDelete,
    deleteRecord,
    confirmDisable,
    disableRecord,
    confirmEnable,
    enableRecord
};
