<template>
    <span>
        <a class="btn btn-sm" v-if="appreciation" @click="editAppreciation()">
            <span v-if="appreciation.level === 0">&#x1F612;</span>
            <span v-else-if="appreciation.level === 1">&#x1F641;</span>
            <span v-else-if="appreciation.level === 2">&#x1F642;</span>
            <span v-else-if="appreciation.level === 3">&#x1F60A;</span>
            <span v-else >&#x1F604;</span>
        </a>
        <a class="btn btn-sm" v-else @click="addAppreciation()">
            <span class="badge badge-default">Set Appreciation</span>
        </a>

        <appreciation-addupdate ref="diffForm" :model_type_prop="model_type" :model_id_prop="model_id" :model_uuid_prop="model_uuid" :appreciation_prop="appreciation"></appreciation-addupdate>
    </span>
</template>

<script>
    import AppreciationAddupdate from "./appreciation-addupdate";

    export default {
        name: "appreciation-item",
        props: {
            appreciations_prop: null,
            model_type_prop: '',
            model_id_prop: '',
            model_uuid_prop: ''
        },
        components: {
            AppreciationAddupdate//: () => import('./appreciation-addupdate'),
        },
        data() {
            return {
                appreciation: this.appreciations_prop ? this.appreciations_prop[0] : null,
                model_type: this.model_type_prop,
                model_id: this.model_id_prop,
                model_uuid: this.model_uuid_prop
            }
        },
        mounted() {
            this.$on('appreciation_created', (added_data) => {
                if (this.model_uuid === added_data.modelUuid) {
                    this.setAppreciation(added_data.appreciation)
                }
            })

            this.$on('appreciation_updated', (upd_data) => {
                if (this.model_uuid === upd_data.modelUuid) {
                    this.setAppreciation(upd_data.appreciation)
                }
            })
        },
        methods: {
            addAppreciation() {
                this.$emit('appreciation_create')
            },
            editAppreciation() {
                this.$emit('appreciation_edit')
            },
            setAppreciation(appreciation) {
                this.appreciation = appreciation
            }
        },
        computed: {

        }
    }
</script>

<style scoped>

</style>
