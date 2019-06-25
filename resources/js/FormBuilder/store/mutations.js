export default {
    SET_TITLE : (state, title) => {
        state.title = title
    },
    SET_DESCRIPTION : (state, description) => {
        state.description = description
    },
    ADD_FIELD : (state, field) => {
        state.form = this.form.push(this.field)
    }
}