import Request from '../core/Request';

class ProgramRecords extends Request{
    retrieve(program, recordType) {
        return this.get(`/api/programs/${program}/records/${recordType}`);
    }

    /*store(recordType, record, program) {
        return this.post(`/api/records/${recordType}/${record}/programs/${program}`);
    }

    destroy(recordType, record, program) {
        return this.delete(`/api/records/${recordType}/${record}/programs/${program}`);
    }*/
}

export default ProgramRecords
