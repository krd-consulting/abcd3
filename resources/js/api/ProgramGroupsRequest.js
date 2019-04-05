import Request from '../core/Request';

class ProgramGroupsRequest extends Request{
    retrieve(program) {
        return this.get(`/api/programs/${program}/groups`);
    }

    /*store(program, recordType, record) {
        return this.post(`/api/programs/${program}/records/${recordType}/${record}`);
    }

    destroy(program, recordType, record) {
        console.log(`/api/programs/${program}/records/${recordType}/${record}`);

        return this.delete(`/api/programs/${program}/records/${recordType}/${record}`);
    }*/
}

export default ProgramGroupsRequest
