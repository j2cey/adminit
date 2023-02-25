<template>

</template>

<script>
    export default {
        name: "highlight-item",
        props: {
            highlight_prop: {},
        },
        components: {
            highlighttextcolor: () => import('./innerhighlights/highlighttextcolor'),
            highlighttextsize: () => import('./innerhighlights/highlighttextsize'),
            highlighttextweight: () => import('./innerhighlights/highlighttextweight'),
        },
        created() {
            //axios.get('/highlighttypes.fetchall').then(({data}) => this.highlighttypes = data);
        },
        data() {
            return {
                highlight: this.highlight_prop,
            }
        },
        methods: {

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
