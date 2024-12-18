import Request from '@/api/FormRequest.js'

export default {
    addField(field) {
        field.commit('ADD_FIELD')
    },

    submitForm({ state }) {
        // console.log(state)

        const formData = {
            name: state.title,
            description: state.description,
            owner_id: state.owner_id,
            scope_id: state.scope_id,
            type: state.type,
            target_type_id: state.target.type.id,
            target_id: state.target.id,
            fields: state.fields
        }

        const request = new Request(formData);

        return request.store();

    }
}
