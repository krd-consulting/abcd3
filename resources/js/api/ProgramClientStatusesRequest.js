import Request from '../core/Request';

class ProgramClientStatusesRequest extends Request{
    retrieve() {
        return this.get(`/api/program-client-statuses`);
    }
}

export default ProgramClientStatusesRequest
