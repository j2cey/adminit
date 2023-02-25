<template>
    <div class="card-comments">
        <ul class="todo-list" data-widget="todo-list">
            <li class="list-group-item" v-for="(comment, idx) in comments" :key="comment.id">
                <comment-item :comment_prop="comment" :model_type_prop="model_type" :model_id_prop="model_id"></comment-item>
            </li>
        </ul>

        <div>
            <comment-addupdate :model_type_prop="model_type" :model_id_prop="model_id"></comment-addupdate>
        </div>
    </div>
</template>

<script>
    import CommentAddupdate from './comment-addupdate';
    import CommentItem from './comment-item';
    import CommentBus from "./commentBus";

    export default {
        name: "comments-list",
        props: {
            comments_prop: {},
            model_type_prop: '',
            model_id_prop: ''
        },
        components: {
            CommentAddupdate, CommentItem
        },
        mounted() {
            CommentBus.$on('comment_created', (add_data) => {
                if (this.model_type === add_data.modelType && this.model_id === add_data.modelId) {
                    this.addComment(add_data.comment)
                }
            })
            this.$on('comment_deleted', (comment) => {
                this.deleteComment(comment);
            })
        },
        data() {
            return {
                comments: this.comments_prop,
                model_type: this.model_type_prop,
                model_id: this.model_id_prop
            }
        },
        methods: {
            addComment(comment) {
                let commentIndex = this.comments.findIndex(c => {
                    return comment.id === c.id
                })
                // if this comment does not already exists, it is inserted in the list
                if (commentIndex === -1) {
                    window.noty({
                        message: 'Comment successfully created',
                        type: 'success'
                    })
                    this.comments.push(comment)
                }
            },
            deleteComment(comment) {
                let commentIndex = this.comments.findIndex(c => {
                    return comment.id === c.id
                })
                // if this comment exists, it is removed from list
                if (commentIndex !== -1) {
                    window.noty({
                        message: 'Comment successfully deleted',
                        type: 'success'
                    })
                    this.comments.splice(commentIndex, 1)
                }
            }
        }
    }
</script>

<style scoped>

</style>
