import Request from '../core/Request';

class EntityTypeForms extends Request {
    retrieve(entityType, id) {
        return this.get(`/api/forms/entity-types/${entityType}/${id}`);
    }
}

export default EntityTypeForms
