<template>
    <div>
        <div class="modal-body">
            <form class="form-horizontal" @submit.prevent @keydown="commentForm.errors.clear()">

                <div class="input-group">
                    <input type="text" class="form-control" name="comment_text" autocomplete="comment_text" autofocus placeholder="Type Comment ..." v-model="commentForm.comment_text">
                    <span class="invalid-feedback d-block" role="alert" v-if="commentForm.errors.has('comment_text')" v-text="commentForm.errors.get('comment_text')"></span>
                    <span class="input-group-append">
                        <button type="button" class="btn btn-secondary btn-sm" @click="initCommentForm(model_type_prop,model_id_prop)">Cancel</button>
                        <button type="button" class="btn btn-warning btn-sm" @click="updateComment(modelType,modelId)" :disabled="!isValidCreateForm" v-if="editing">Update</button>
                        <button type="button" class="btn btn-warning btn-sm" @click="createComment(modelType,modelId)" :disabled="!isValidCreateForm" v-else>Create</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import CommentBus from "./commentBus";

    class Comment {
        constructor(comment) {
            this.comment_text = comment.comment_text || ''
            this.description = comment.description || ''
            this.model_type = comment.model_type || ''
            this.model_id = comment.model_id || ''
            this.posi = comment.posi || ''
        }
    }
    export default {
        name: "comment-addupdate",
        props: {
            model_type_prop: '',
            model_id_prop: ''
        },
        mounted() {
            CommentBus.$on('comment_create', (modelType, modelId) => {
                if (this.model_type_prop === modelType && this.model_id_prop === modelId) {
                    this.initCommentForm(modelType, modelId)
                }
            })
            CommentBus.$on('comment_edit', (comment, modelType, modelId) => {
                if (this.model_type_prop === modelType && this.model_id_prop === modelId) {
                    this.editing = true
                    this.comment = new Comment(comment)
                    this.commentForm = new Form(this.comment)
                    this.commentId = comment.uuid
                }
            })
        },
        created() {
            this.initCommentForm(this.model_type_prop, this.model_id_prop)
        },
        data() {
            return {
                comment: {},
                modelId: '',
                modelType: '',
                commentForm: new Form(new Comment({})),
                commentId: null,
                editing: false,
                loading: false
            }
        },
        methods: {
            initCommentForm(modelType, modelId) {
                this.editing = false
                this.comment = new Comment({})
                this.comment.model_type = modelType
                this.comment.model_id = modelId

                this.modelType = modelType
                this.modelId = modelId

                this.commentForm = new Form(this.comment)
            },
            createComment(modelType,modelId) {
                this.loading = true
                this.commentForm
                    .post('/comments')
                    .then(comment => {
                        this.loading = false
                        CommentBus.$emit('comment_created', {comment, modelType, modelId})
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateComment(modelType,modelId) {
                this.loading = true
                this.commentForm
                    .put(`/comments/${this.commentId}`, undefined)
                    .then(comment => {
                        this.loading = false
                        this.initCommentForm(this.model_type_prop, this.model_id_prop)
                        CommentBus.$emit('comment_updated', {comment, modelType, modelId})
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
