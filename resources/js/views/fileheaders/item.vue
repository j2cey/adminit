<template>
    <section>
        <div class="box">

            <div class="row">
                <div class="col">
                    <b-field size="is-small" horizontal>
                        <template #label><span class="has-text-primary text-xs">Titre</span></template>
                        <b-field :type="fileHeaderForm.errors.has('title') ? 'is-danger' : 'is-default'">
                            <b-tooltip :active="fileHeaderForm.errors.has('title')" :label="fileHeaderForm.errors.get('title')"
                                       position="is-bottom"
                                       type="is-danger"
                                       :animated="false">
                                <b-input custom-class="transinput" size="is-small" v-model="fileHeaderForm.title" name="title" placeholder="Titre" :readonly="!editing"></b-input>
                            </b-tooltip>
                        </b-field>
                    </b-field>
                    <b-field size="is-small" horizontal>
                        <template #label><span class="has-text-primary text-xs">Description</span></template>
                        <b-field>
                            <b-input style="border-style:none;" size="is-small" v-model="fileHeaderForm.description" name="description" placeholder="Description" :readonly="!editing"></b-input>
                        </b-field>
                    </b-field>
                    <b-field size="is-small" horizontal>
                        <template #label><span class="has-text-primary text-xs">Création</span></template>
                        <b-field>
                            <b-input size="is-small" :value="fileheader.created_at | formatDate" name="created_at" placeholder="Created at" readonly></b-input>
                        </b-field>
                    </b-field>

                    <b-field class="text-xs" position="is-right">
                        <a @click="editFileHeader(fileheader)" v-if="!editing" class="tw-inline-block tw-mr-3 text-warning">
                            <b-icon
                                pack="fas"
                                icon="pencil-square-o"
                                size="is-small">
                            </b-icon>
                        </a>
                        <a @click="updateFileHeader(fileheader)" v-if="editing" class="tw-inline-block tw-mr-3 text-success">
                            <b-icon
                                pack="fas"
                                icon="check"
                                size="is-small">
                            </b-icon>
                        </a>
                        <a @click="cancelEditFileHeader(fileheader)" v-if="editing" class="tw-inline-block tw-mr-3 text-info">
                            <b-icon
                                pack="fas"
                                icon="ban"
                                size="is-small">
                            </b-icon>
                        </a>
                        <a @click="deleteFileHeader(fileheader)" class="tw-inline-block tw-mr-3 text-danger">
                            <b-icon
                                pack="fas"
                                icon="trash"
                                size="is-small">
                            </b-icon>
                        </a>
                    </b-field>
                </div>

                <div class="col">
                    <FormatRuleList :model_prop="fileheader"></FormatRuleList>
                </div>
            </div>

        </div>
    </section>
</template>

<script>

class FileHeader {
    constructor(fileheader) {
        this.title = fileheader.title || ''
        this.description = fileheader.description || ''

        this.model_type = fileheader.model_type || ''
        this.model_id = fileheader.model_id || ''
    }
}

export default {
    name: "fileheader-item",
    props: {
        fileheader_prop: {},
    },
    components: {
        FormatRuleList: () => import('../formatrules/list'),
    },
    data() {
        return {
            fileheader: this.fileheader_prop,
            fileHeaderForm: new Form(new FileHeader(this.fileheader_prop)),

            editing: false,
            loading: false,
        };
    },
    methods: {
        editFileHeader() {
            this.editing = true
        },
        cancelEditFileHeader() {
            this.editing = false
            this.loading = false
        },
        setFileHeaderUpdated(fileheader) {
            this.fileHeaderForm = new Form(new FileHeader(fileheader))
            this.cancelEditFileHeader(fileheader)
        },
        updateFileHeader(fileheader) {
            this.loading = true

            this.fileHeaderForm
                .put(`/fileheaders/${this.fileheader.uuid}`,undefined)
                .then(fileheader => {
                    this.loading = false
                    this.$swal({
                        html: '<small>En-tête modifiée avec succès !</small>',
                        icon: 'success',
                        timer: 3000
                    }).then(() => {
                        this.loading = false
                        this.setFileHeaderUpdated(fileheader)
                    })

                }).catch(error => {
                this.loading = false
                this.cancelEditFileHeader(fileheader)
            });
        },
        deleteFileHeader(fileheader) {
            this.$swal({
                title: "Suppresion de l'En-tête",
                text: "Validez la Suppression!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui'
            }).then((result) => {
                if(result.value) {

                    this.loading = true

                    axios.delete(`/fileheaders/${fileheader.uuid}`)
                        .then(resp => {
                            this.loading = false
                        }).catch(error => {
                        this.loading = false
                        window.handleErrors(error)
                    })
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
