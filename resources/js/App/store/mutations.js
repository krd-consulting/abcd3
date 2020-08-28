import { updateField } from "vuex-map-fields";

export default {
  updateField,
  SET_TITLE: (state, title) => {
    state.title = title;
  },
  SET_DESCRIPTION: (state, description) => {
    state.description = description;
  },
  SET_OWNER_ID: (state, owner) => {
    state.owner_id = owner;
  },
  SET_SCOPE_ID: (state, scope) => {
    state.scope_id = scope;
  },
  SET_TYPE: (state, type) => {
    state.type = type;
  },
  SET_TARGET: (state, target) => {
    state.target = target;
  },

  SET_FIELDS: (state, fields) => {
    state.fields = fields;
  },

  ADD_FIELD: (state, field) => {
    state.fields.push(field);
  },

  UPDATE_FIELD: (state, payload) => {
    state.fields[payload.fieldIndex] = payload.field;
  },

  // not being referenced
  UPDATE_FIELD_CHOICES: (state, payload) => {
    state.fields[payload.fieldIndex].choices = payload.field.choices;
  },

  REMOVE_FIELD: (state, fieldIndex) => {
    state.fields.splice(fieldIndex, 1);
  }
};
