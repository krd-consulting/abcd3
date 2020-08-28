import { getField } from "vuex-map-fields";

export default {
  getField,
  getTitle: state => {
    return state.title;
  },
  getDescription: state => {
    return state.description;
  },
  formData: state => {
    return state;
  }
};
