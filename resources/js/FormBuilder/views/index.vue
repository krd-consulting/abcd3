<template>
    <div id="formCreator">
        <el-container>
            <el-card id="menu-container">
                <form-menu id="menu"/>
            </el-card>

            <el-card id="canvas-container">
                <el-header>
                    <nav-bar>
                        <template v-slot:mobile>
                            <menu-panel>
                                <template v-slot:button-text>
                                    <span class="tw-float-left tw-mr-1 mobile-menu">
                                        <base-icon class="tw-align-middle">menu</base-icon>
                                    </span>
                                </template>
                                <form-menu id="menu"/>
                            </menu-panel>
                        </template>
                    </nav-bar>
                </el-header>

                <form-canvas :fields="fields" id="canvas"/>

            </el-card>

        </el-container>
        <initialize :active.sync="initialize.active" @save="initializeForm"/>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import FormCanvas from '@/FormBuilder/components/canvas/index.vue'
    import FormMenu from '@/FormBuilder/components/menu/index.vue'
    import MenuPanel from '@/FormBuilder/components/menu/mobileMenu.vue'
    import NavBar from '@/FormBuilder/components/navbar.vue'
    import Initialize from './initialize'

    export default {
        name: 'Form',
        data: () => {
            return {
                activeIndex: '1',
                fields: [],
                initialize: {
                    active: false
                }
            }
        },

        components: {
            FormCanvas,
            FormMenu,
            draggable,
            MenuPanel,
            NavBar,
            Initialize
        },
        computed: {
            title: {
                get() { return this.$store.state.title },
                set(title) { this.$store.commit('SET_TITLE', title) },
            },

            description: {
                get() { return this.$store.state.description },
                set(description) { this.$store.commit('SET_DESCRIPTION', description) }
            },

            owner_id: {
                get() { return this.$store.state.owner_id },
                set(owner_id) { this.$store.commit('SET_OWNER_ID', owner_id) }
            },

            scope_id: {
                get() { return this.$store.state.scope_id },
                set(scope_id) { this.$store.commit('SET_SCOPE_ID', scope_id) }
            },

            type: {
                get() { return this.$store.state.type },
                set(type) { this.$store.commit('SET_TYPE', type) }
            },

            target: {
                get() { return this.$store.state.target },
                set(target) { this.$store.commit('SET_TARGET', target) },
            },
        },
        methods: {
            initializeForm(data) {
                this.title = data.name;
                this.description = data.description;
                this.owner_id = data.owner_id;
                this.scope_id = data.scope_id;
                this.type = data.type;
                this.target = data.target;
            }
        },
    }
</script>

<style scoped>

#formCreator {
    display: flex;
    flex-direction: row;
    align-items: center;
}
#canvas {
    width: 100%;
    padding-right: 15px;
}

/* Tablet/Reduced Screen View */
@media (min-width: 500px){

    #canvas-container {
        flex: 100%;
        margin-left: 1%;
        margin-right: 1%;
        min-width: 500px;
    }
    .mobile-menu {
        display: inherit;
    }
    #menu-container {
        display: none;
    }
}

/* Desktop View */
@media (min-width: 1024px){
    #canvas-container {
        flex: 80%;
        margin-left: 10px;
        margin-right: 5%;
        min-width: 500px;
    }

    .el-header {
        min-width: 500px;
    }
    .mobile-menu {
        display: none;
    }
    #menu-container {
        flex: 22%;
        display: block;
        padding-top: 60px;
        padding-bottom: 10px;
        margin: 0 auto;
        margin-left: 5%;
        min-width: 300px;
        max-width: 450px;
        max-height: 900px;
    }
    .float-right {
        float: right !important;
    }
}

</style>

