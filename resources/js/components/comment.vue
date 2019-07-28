<template>
    <div class="media my-3">
        <avatar :username="comment.user.name"
                width="30" height="30" class="rounded-circle mr-3"></avatar>

        <div class="media-body">
            <h6 class="mt-0">{{ comment.user.name }}</h6>

            <small>{{ comment.body }}</small>

            <div class="d-flex">
                <votes :init-votes="comment.votes"
                       :entity-id="comment.id"
                       :entity-owner-id="comment.user.id"></votes>

                <button @click="toggleAddReply = !toggleAddReply"
                        class="btn btn-sm ml-4"
                        :class="{ 'btn-outline-dark': !toggleAddReply, 'btn-dark': toggleAddReply }">
                    <small>{{ toggleAddReply ? 'Cancel' : 'Add Reply' }}</small>
                </button>
            </div>

            <div v-show="toggleAddReply" class="form-inline my-4 w-full">
                <input v-model="newReply" type="text" class="form-control form-control-sm w-80">
                <button @click="addReply" class="btn btn-sm btn-primary">
                    <small>Add Reply</small>
                </button>
            </div>

            <replies ref="replies" :comment="comment"></replies>
        </div>
    </div>
</template>

<script>
import Avatar from 'vue-avatar';
import Replies from './replies.vue';
import Votes from './votes';

export default {
    components: { Avatar, Replies, Votes },
    props: ['comment', 'video'],
    data() {
        return {
            toggleAddReply: false,
            newReply: '',
        };
    },
    methods: {
        addReply() {
            //return console.log(this.$refs.replies);

            if (!this.newReply.trim()) return;

            axios.post(`/comments/${this.video.id}`, {
                body: this.newReply,
                comment_id: this.comment.id
            }).then(({ data:newReply }) => {
                console.log(newReply);

                // Cách để trigger Replies component cập nhật data của nó (replies)
                // (Vì nó ko nhận props nào lquan đến data mà mình cần nó cập nhật)
                this.$refs.replies.addReply(newReply);

                this.newReply = '';
                this.toggleAddReply = false;
            }).catch(err => console.log(err));
        }
    }
}
</script>

<style></style>