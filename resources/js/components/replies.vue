<template>
    <div>
        <div v-for="reply in replies.data" :key="reply.id" class="media my-4">
            <a class="mr-3" href="#">
                <avatar :username="reply.user.name"
                        width="30" height="30" class="rounded-circle mr-3"></avatar>
            </a>
            <div class="media-body">
                <h6 class="mt-0">{{ reply.user.name }}</h6>
                <small >{{ reply.body }}</small>
                <votes :init-votes="reply.votes"
                       :entity-id="reply.id"
                       :entity-owner-id="reply.user.id"></votes>
            </div>
        </div>

        <div v-if="!!comment.total_replies && canLoadMore" class="text-right">
            <a @click="fetchReplies" class="text-info h6" style="cursor: pointer;">Load Replies</a>
        </div>
    </div>
</template>

<script>
import Avatar from 'vue-avatar';

export default {
    components: { Avatar },
    props: ['comment'],
    data() {
        return {
            replies: {
                data: []
            }
        };
    },
    computed: {
        canLoadMore() {
            return ('next_page_url' in this.replies) ? !!this.replies.next_page_url : true;
        }
    },
    methods: {
        fetchReplies() {
            if (this.canLoadMore) {
                const url = this.replies.next_page_url || `/comments/${this.comment.id}/replies`;
                axios.get(url)
                    .then(res => {
                        this.replies = {
                            ...res.data,
                            data: [
                                ...this.replies.data,
                                ...res.data.data
                            ]
                        };
                    })
                    .catch(err => console.log(err));
            }
        },
        addReply(reply) {
            this.replies = {
                ...this.replies,
                data: [
                    reply,
                    ...this.replies.data
                ]
            };
        }
    }
}
</script>

<style></style>