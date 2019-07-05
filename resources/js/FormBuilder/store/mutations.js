export default {
    SET_TITLE : (state, title) => {
        state.title = title
    },
    SET_DESCRIPTION : (state, description) => {
        state.description = description
    },
    SET_TYPE : (state, type) => {
        state.type = type
    },
    SET_TARGET : (state, target) => {
        state.target = target
    },

    SET_FIELDS : (state, fields) => {
        state.fields = fields
    },

    ADD_FIELD : (state, field) => {
        state.fields.push(field);
    },

    UPDATE_FIELD : (state, payload) => {
        state.fields[payload.fieldIndex] = payload.field;
    },

    REMOVE_FIELD : (state, fieldIndex) => {
        state.fields.splice(fieldIndex, 1);
    }
}