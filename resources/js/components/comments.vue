<template>
    <div class="card mt-5 p-5">
        <div v-if="isLoggedIn" class="form-inline my-4 w-full">
            <input type="text" v-model="newComment"
                   class="form-control form-control-sm w-80">
            <button @click="addComment" class="btn btn-sm btn-primary">
                <small>Add comment</small>
            </button>
        </div>

        <comment v-for="comment in comments.data"
                 :key="comment.id"
                 :comment="comment"
                 :video="video"></comment>

        <div class="text-center">
            <button @click="fetchComments" v-if="canLoadMore"
                    class="btn btn-success">Load More</button>
            <span v-else class="text-danger">No more comments to show.</span>
        </div>
    </div>
</template>

<script>
import Comment from './comment';

export default {
    components: {Comment},
    props: ['video'],
    data() {
        return {
            comments: {
                data: []
            },
            newComment: '',
        };
    },
    computed: {
        canLoadMore() {
            return ('next_page_url' in this.comments) ? !!this.comments.next_page_url : true;
        },
        isLoggedIn() {
            return __auth();
        },
    },
    mounted() {
        this.fetchComments();
    },
    methods: {
        fetchComments() {
            const url = this.comments.next_page_url ? this.comments.next_page_url : `/videos/${this.video.id}/comments`;
            if (this.canLoadMore) {
                axios.get(url)
                    .then(res => {
                        //console.log(res.data);
                        this.comments = {
                            ...res.data,
                            data: [
                                ...this.comments.data,
                                ...res.data.data
                            ],
                        };
                    })
                    .catch(err => console.log(err));
            }
        },
        addComment() {
            if (!this.newComment.trim()) return;

            axios.post(`/comments/${this.video.id}`, {
                body: this.newComment
            }).then(({ data:newComment }) => {
                //console.log(newComment);
                this.comments = {
                    ...this.comments,
                    data: [
                        newComment,
                        ...this.comments.data
                    ]
                };
                this.newComment = '';
            }).catch(err => console.log(err));
        },
    }
}
</script>

<style></style>