import Request from '../core/Request';

class ProgramClientStatusRequest extends Request{
    retrieve() {
        return this.get(`/api/program-client-statuses`);
    }
}

export default ProgramClientStatusRequest
