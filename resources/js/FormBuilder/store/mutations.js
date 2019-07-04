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
    ADD_FIELD : (state, field) => {
        state.form = this.form.push(this.field)
    }
}