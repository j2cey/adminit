<template>
    <span>
        <a class="btn btn-sm" v-if="difficulty" @click="editDifficulty()">
            <span class="badge badge-light">Difficulty
                <span v-if="difficulty.level === 0" class="badge badge-pill badge-success">{{difficulty.title}}</span>
                <span v-else-if="difficulty.level === 1" class="badge badge-pill badge-info">{{difficulty.title}}</span>
                <span v-else-if="difficulty.level === 2" class="badge badge-pill badge-primary">{{difficulty.title}}</span>
                <span v-else-if="difficulty.level === 3" class="badge badge-pill badge-warning">{{difficulty.title}}</span>
                <span v-else class="badge badge-pill badge-danger">{{difficulty.title}}</span>
            </span>
        </a>
        <a class="btn btn-sm" v-else @click="addDifficulty()">
            <span class="badge badge-default">Set Difficulty</span>
        </a>

        <difficulty-addupdate ref="diffForm" :model_type_prop="model_type" :model_id_prop="model_id" :model_uuid_prop="model_uuid" :difficulty_prop="difficulty"></difficulty-addupdate>
    </span>
</template>

<script>
    import DifficultyAddupdate from "./difficulty-addupdate";

    export default {
        name: "difficulty-item",
        props: {
            difficulties_prop: null,
            model_type_prop: '',
            model_id_prop: '',
            model_uuid_prop: ''
        },
        components: {
            DifficultyAddupdate//: () => import('./difficulty-addupdate'),
        },
        data() {
            return {
                difficulty: this.difficulties_prop ? this.difficulties_prop[0] : null,
                model_type: this.model_type_prop,
                model_id: this.model_id_prop,
                model_uuid: this.model_uuid_prop
            }
        },
        mounted() {
            this.$on('difficulty_created', (added_data) => {
                if (this.model_uuid === added_data.modelUuid) {
                    this.setDifficulty(added_data.difficulty)
                }
            })

            this.$on('difficulty_updated', (upd_data) => {
                if (this.model_uuid === upd_data.modelUuid) {
                    this.setDifficulty(upd_data.difficulty)
                }
            })
        },
        methods: {
            addDifficulty() {
                this.$emit('difficulty_create')
            },
            editDifficulty() {
                this.$emit('difficulty_edit')
            },
            setDifficulty(difficulty) {
                this.difficulty = difficulty
            }
        },
        computed: {

        }
    }
</script>

<style scoped>

</style>
