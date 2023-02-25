<template>
    <b-field grouped group-multiline>
        <div class="control">
            <b-taglist attached>
                <b-tag rounded type="is-primary is-light" size="is-small" v-if="innerhighlight.highlight" v-model="innerhighlight.highlight">{{ innerhighlight.highlight }}</b-tag>
                <b-tag rounded type="is-danger is-light" size="is-small" v-else v-model="innerhighlight.highlight">{{ innerhighlight.highlight }}</b-tag>
                <b-tag rounded type="is-ghost btn" @click="updateHighlightValue()"> <i class="fa fa-pencil-square-o"></i> </b-tag>
            </b-taglist>
        </div>
    </b-field>
</template>

<script>

    class InnerHighlight {
        constructor(innerhighlight) {
            this.highlight = innerhighlight.highlight || ''
            this.comment = innerhighlight.comment || ''
            this.status = innerhighlight.status || ''
        }
    }
    export default {
        name: "highlighttextweight",
        props: {
            innerhighlight_prop: {},
            model_type_prop: "",
        },
        components: {

        },
        created() {

        },
        data() {
            return {
                model_type: this.model_type_prop,
                innerhighlight: this.innerhighlight_prop,
                innerhighlightForm: new Form( this.innerhighlight_prop ),
                editing: false,
                loading: false,
            }
        },
        methods: {
            async updateHighlightValue() {

                const { value: weight } = await Swal.fire({
                    html: '<small>Select Text Weight</small>',
                    input: 'select',
                    inputOptions: {
                        normal: 'Normal',
                        light: 'Light',
                        middle: 'Middle',
                        bold: 'Bold'
                    },
                    inputPlaceholder: '<small>Select Text Weight</small>',
                    showCancelButton: true,
                    inputValidator: (value) => {
                        if (!value) {
                            return 'You need to choose something!'
                        }
                    }
                })

                if (weight) {

                    this.innerhighlightForm.highlight = weight

                    this.loading = true
                    const fd = undefined;

                    this.innerhighlightForm
                        .put(`/highlighttextweights/${this.innerhighlight.uuid}`, fd)
                        .then(innerhighlight => {
                            this.loading = false
                            console.log('innerhighlight upd: ', innerhighlight)
                            this.$swal({
                                html: '<small>Text Weight Successfully Updated !</small>',
                                icon: 'success',
                                timer: 3000
                            }).then(() => {
                                this.innerhighlight = innerhighlight
                            })
                        }).catch(error => {
                        this.loading = false
                    }).finally(
                        this.innerhighlightForm = new Form( this.innerhighlight )
                    );
                }
            }
        },
        computed: {
            isValidCreateForm() {
                return !this.loading
            },
        }
    }
</script>

<style scoped>

</style>
