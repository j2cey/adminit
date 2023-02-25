<template>
    <div class="modal fade draggable" :id="modal_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form-vertical" @submit.prevent @keydown="difficultyForm.errors.clear()">
                        <div class="input-group mb-3">
                            <div class="input">
                                <multiselect
                                    v-model="difficultyForm.difficulty"
                                    selected.sync="difficultyForm.difficulty"
                                    value=""
                                    :options="difficulties"
                                    :searchable="true"
                                    :multiple="false"
                                    label="title"
                                    track-by="id"
                                    key="id"
                                    placeholder="Difficulty"
                                >
                                </multiselect>
                                <span class="invalid-feedback d-block" role="alert" v-if="difficultyForm.errors.has('difficulty')" v-text="difficultyForm.errors.get('difficulty')"></span>
                            </div>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa fa-times"></i></button>
                                <button type="button" class="btn btn-warning btn-sm" @click="updateDifficulty(model_uuid)" :disabled="!isValidCreateForm" v-if="editing"><i class="fa fa-check"></i></button>
                                <button type="button" class="btn btn-warning btn-sm" @click="createDifficulty(model_uuid)" :disabled="!isValidCreateForm" v-else><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';

    class Difficulty {
        constructor(difficulty_obj) {
            this.difficulty = difficulty_obj.difficulty || ''
            this.model_type = difficulty_obj.model_type || ''
            this.model_id = difficulty_obj.model_id || ''
            this.posi = difficulty_obj.posi || ''
        }
    }
    export default {
        name: "difficulty-addupdate",
        props: {
            model_type_prop: '',
            model_id_prop: '',
            model_uuid_prop: '',
            difficulty_prop: null
        },
        components: { Multiselect },
        beforeMount () {
            // save props data to itself's data and deal with it
            this.model_type = this.model_type_prop
            this.model_id = this.model_id_prop
            this.model_uuid = this.model_uuid_prop
            this.modal_id = 'addUpdateDifficulty_' + this.model_uuid
            this.modal_ref = '#addUpdateDifficulty_' + this.model_uuid
            this.difficulty = this.difficulty_prop
        },
        mounted() {
            this.$parent.$on('difficulty_create', () => {
                this.initDifficultyForm()
                $(this.modal_ref).modal()
            })
            this.$parent.$on('difficulty_edit', () => {
                this.editing = true
                this.difficulty_obj = new Difficulty({})
                this.difficulty_obj.difficulty = this.difficulty
                this.difficulty_obj.model_type = this.model_type
                this.difficulty_obj.model_id = this.model_id

                this.difficultyForm = new Form(this.difficulty_obj)
                this.difficultyId = this.difficulty.uuid
                $(this.modal_ref).modal()
            })
        },
        created() {
            axios.get('/difficulties')
                .then(({data}) => this.difficulties = data);

            this.initDifficultyForm();
        },
        data() {
            return {
                difficulty_obj: {},
                difficulty: {},
                model_id: '',
                model_type: '',
                model_uuid: '',
                modal_id: '',
                modal_ref: '',
                difficultyForm: new Form(new Difficulty({})),
                difficultyId: null,
                editing: false,
                loading: false,
                difficulties: [],
            }
        },
        methods: {
            initDifficultyForm() {
                this.editing = false
                this.difficulty_obj = new Difficulty({})
                this.difficulty_obj.model_type = this.model_type
                this.difficulty_obj.model_id = this.model_id
                this.difficulty_obj.difficulty = null

                this.difficultyForm = new Form(this.difficulty_obj)
            },
            createDifficulty(modelUuid) {
                this.loading = true
                this.difficultyForm
                    .post('/difficulties/add')
                    .then(difficulty => {
                        this.loading = false
                        this.difficulty = difficulty
                        this.$parent.$emit('difficulty_created', { difficulty, modelUuid })
                        $(this.modal_ref).modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateDifficulty(modelUuid) {
                this.loading = true
                this.difficultyForm
                    .put(`/difficulties/${this.difficultyId}`, undefined)
                    .then(difficulty => {
                        this.loading = false
                        this.difficulty = difficulty
                        this.initDifficultyForm()
                        this.$parent.$emit('difficulty_updated', { difficulty, modelUuid })
                        $(this.modal_ref).modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
        },
        computed: {
            isValidCreateForm() {
                return !this.loading
            }
        }
    }
</script>

<style scoped>

</style>
