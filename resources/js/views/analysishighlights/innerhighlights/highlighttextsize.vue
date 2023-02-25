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
    const inputOptions = new Promise((resolve) => {
        setTimeout(() => {
            resolve({
                'red': 'Red',
                'green': 'Green',
                'blue': 'Blue',
                'black': 'Black'
            })
        }, 1000)
    })

    class InnerHighlight {
        constructor(innerhighlight) {
            this.highlight = innerhighlight.highlight || ''
            this.comment = innerhighlight.comment || ''
            this.status = innerhighlight.status || ''
        }
    }

    export default {
        name: "highlighttextsize",
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

                const { value: size } = await Swal.fire({
                    input: 'range',
                    html: '<small>Set the Size</small>',
                    inputAttributes: {
                        min: 8,
                        max: 30,
                        step: 1
                    },
                    inputValue: 8
                })

                if (size) {

                    this.innerhighlightForm.highlight = size

                    this.loading = true
                    const fd = undefined;

                    this.innerhighlightForm
                        .put(`/highlighttextsizes/${this.innerhighlight.uuid}`, fd)
                        .then(innerhighlight => {
                            this.loading = false
                            console.log('innerhighlight upd: ', innerhighlight)
                            this.$swal({
                                html: '<small>Text Size Successfully Updated !</small>',
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
