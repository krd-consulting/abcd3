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
            team_id: state.team_id,
            scope_id: state.scope_id,
            type: state.type,
            reference_target_type_id: state.target.type.id,
            reference_target_id: state.target.id,
            fields: state.fields
        }

        const request = new Request(formData);

        request.store()
            .then((response) => {
                //  return Promise('')
                
            })
            .catch((error) => {
                //
            });
    }
}