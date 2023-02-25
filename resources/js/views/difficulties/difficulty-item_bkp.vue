<template>
    <span>
        <a class="btn btn-sm" v-if="difficulty_sel" @click="editDifficulty(difficulty_sel)">
            <span class="badge badge-light">Difficulty
                <span v-if="difficulty_sel.level === 0" class="badge badge-pill badge-success">{{difficulty_sel.title}}</span>
                <span v-else-if="difficulty_sel.level === 1" class="badge badge-pill badge-info">{{difficulty_sel.title}}</span>
                <span v-else-if="difficulty_sel.level === 2" class="badge badge-pill badge-primary">{{difficulty_sel.title}}</span>
                <span v-else-if="difficulty_sel.level === 3" class="badge badge-pill badge-warning">{{difficulty_sel.title}}</span>
                <span v-else class="badge badge-pill badge-danger">{{difficulty_sel.title}}</span>
            </span>
        </a>
        <a class="btn btn-sm" v-else @click="addDifficulty(model_type,model_id)">
            <span class="badge badge-default">Set Difficulty</span>
        </a>


        <div class="modal fade draggable" :id="'addUpdateDifficulty_' + model_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <button type="button" class="btn btn-warning btn-sm" @click="updateDifficulty()" :disabled="!isValidCreateForm" v-if="editing"><i class="fa fa-check"></i></button>
                                <button type="button" class="btn btn-warning btn-sm" @click="createDifficulty()" :disabled="!isValidCreateForm" v-else><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </span>
</template>

<script>
    import Multiselect from 'vue-multiselect';

    class Difficulty {
        constructor(difficulty) {
            this.difficulty = difficulty.difficulty || ''
            this.model_type = difficulty.model_type || ''
            this.model_id = difficulty.model_id || ''
            this.posi = difficulty.posi || ''
        }
    }
    export default {
        name: "difficulty-item_bkp",
        props: {
            difficulties_prop: null,
            model_type_prop: '',
            model_id_prop: ''
        },
        components: {
            Multiselect
        },
        data() {
            return {
                difficulty: {},
                difficulty_sel: this.difficulties_prop ? this.difficulties_prop[0] : null,
                model_type: this.model_type_prop,
                model_id: this.model_id_prop,
                difficultyForm: new Form(new Difficulty({})),
                difficultyId: null,
                editing: false,
                loading: false,
                difficulties: [],
            }
        },
        created() {
            this.initDifficultyForm()
            axios.get('/difficulties')
                .then(({data}) => this.difficulties = data);
        },
        mounted() {
            this.$on('difficulty_updated', (upd_data) => {
                if (this.difficulty.id === upd_data.difficulty.id) {
                    this.updateDifficulty(upd_data.difficulty)
                }
            })

            this.$on('difficulty_created', (added_data) => {
                console.log('difficulty_created', added_data)
                if (this.difficulty.id === added_data.difficulty.id) {
                    this.updateDifficulty(added_data.difficulty)
                }
            })
        },
        methods: {
            initDifficultyForm() {
                this.editing = false
                this.difficulty = new Difficulty({})
                this.difficulty.difficulty = null
                this.difficulty.model_type = this.model_type
                this.difficulty.model_id = this.model_id

                this.difficultyForm = new Form(this.difficulty)
            },
            addDifficulty(modelType, modelId) {
                this.initDifficultyForm();
                var modalref = '#addUpdateDifficulty_' + this.model_id
                $(modalref).modal()
                //this.$refs.diffForm.prepareForCreate();
                //this.$emit('difficulty_create', modelType,modelId)
                //DifficultyBus.$emit('difficulty_create', modelType,modelId)
            },
            editDifficulty(difficulty) {
                this.editing = true

                this.difficulty = new Difficulty({})
                this.difficulty.difficulty = difficulty
                this.difficulty.model_type = this.model_type
                this.difficulty.model_id = this.model_id

                this.difficultyForm = new Form(this.difficulty)
                this.difficultyId = difficulty.uuid
                var modalref = '#addUpdateDifficulty_' + this.model_id
                $(modalref).modal()
                //this.$emit('difficulty_edit', difficulty,modelType,modelId)
            },
            createDifficulty() {
                this.loading = true
                this.difficultyForm
                    .post('/difficulties/add')
                    .then(difficulty => {
                        this.loading = false
                        this.setDifficulty(difficulty);
                        var modalref = '#addUpdateDifficulty_' + this.model_id
                        $(modalref).modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateDifficulty() {
                this.loading = true
                this.difficultyForm
                    .put(`/difficulties/${this.difficultyId}`, undefined)
                    .then(difficulty => {
                        this.loading = false
                        this.initDifficultyForm()
                        this.setDifficulty(difficulty);
                        var modalref = '#addUpdateDifficulty_' + this.model_id
                        $(modalref).modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
            setDifficulty(difficulty) {
                /*window.noty({
                    message: 'Difficulty successfully set',
                    type: 'success'
                })*/
                this.difficulty_sel = difficulty
            }
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
