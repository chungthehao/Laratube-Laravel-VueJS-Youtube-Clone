<template>
    <div class="card mt-5 p-5">
        <div v-for="comment in comments.data"
             :key="comment.id"
             class="media">
            <avatar :username="comment.user.name"
                    width="30" height="30" class="rounded-circle mr-3"></avatar>

            <div class="media-body">
                <h6 class="mt-0">{{ comment.user.name }}</h6>
                <small>{{ comment.body }}</small>
                <div class="form-inline my-4 w-full">
                    <input type="text" class="form-control form-control-sm w-80">
                    <button class="btn btn-sm btn-primary">
                        <small>Add comment</small>
                    </button>
                </div>

                <div class="media mt-3">
                    <a class="mr-3" href="#">
                        <img width="30" height="30" class="rounded-circle mr-3" src="https://picsum.photos/id/42/200/200">
                    </a>
                    <div class="media-body">
                        <h6 class="mt-0">Media heading</h6>
                        <small >Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</small>

                        <div class="form-inline my-4 w-full">
                            <input type="text" class="form-control form-control-sm w-80">
                            <button class="btn btn-sm btn-primary">
                                <small>Add comment</small>
                            </button>
                        </div>
                    </div>
                </div>
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

export default {
    props: ['video'],
    components: { Avatar },
    data() {
        return {
            comments: {
                data: []
            },
        };
    },
    computed: {
        canLoadMore() {
            return ('next_page_url' in this.comments) ? !!this.comments.next_page_url : true;
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
        }
    }
}
</script>

<style></style>