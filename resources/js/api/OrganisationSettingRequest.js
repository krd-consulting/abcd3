import Request from '../core/Request';

class OrganisationSettingRequest extends Request {
    show() {
        return this.get(`/api/organisation-setting`);
    }

    update(form) {
    	return this.patch(`/api/organisation-setting`);
    }
}

export default OrganisationSettingRequest
