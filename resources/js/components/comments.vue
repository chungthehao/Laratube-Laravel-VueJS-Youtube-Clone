<template>
    <div class="card mt-5 p-5">
        <div v-if="isLoggedIn" class="form-inline my-4 w-full">
            <input type="text" v-model="newComment"
                   class="form-control form-control-sm w-80">
            <button @click="addComment" class="btn btn-sm btn-primary">
                <small>Add comment</small>
            </button>
        </div>

        <div v-for="comment in comments.data"
             :key="comment.id"
             class="media my-3">
            <avatar :username="comment.user.name"
                    width="30" height="30" class="rounded-circle mr-3"></avatar>

            <div class="media-body">
                <h6 class="mt-0">{{ comment.user.name }}</h6>

                <small>{{ comment.body }}</small>

                <div class="d-flex">
                    <votes :init-votes="comment.votes"
                           :entity-id="comment.id"
                           :entity-owner-id="comment.user.id"></votes>

                    <button class="btn btn-sm btn-outline-dark ml-4">Add Reply</button>
                </div>

                <replies :comment="comment"></replies>
            </div>
        </div>

        <div class="text-center">
            <button @click="fetchComments" v-if="canLoadMore"
                    class="btn btn-success">Load More</button>
            <span v-else class="text-danger">No more comments to show.</span>
        </div>
    </div>
</template>

<script>
import Avatar from 'vue-avatar';
import Replies from './replies.vue';
import Votes from './votes';

export default {
    props: ['video'],
    components: { Avatar, Replies, Votes },
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