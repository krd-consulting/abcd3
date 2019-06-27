import Request from '../core/Request';

class CasesRequest extends Request{
    retrieve(program, recordType, record) {
        return this.get(`/api/programs/${program}/records/${recordType}/${record}/cases`);
    }

    store(program, recordType, record, recordCase) {
    	return this.post(`/api/programs/${program}/records/${recordType}/${record}/cases/${recordCase}`);
    }

    destroy(program, recordType, record, recordCase) {
        return this.delete(`/api/programs/${program}/records/${recordType}/${record}/cases/${recordCase}`);
    }
}

export default CasesRequest
