
Vue.component('channel-uploads', {
    props: {
        channel: {
            type: Object,
            required: true,
            default: () => ({}),
        }
    },
    data() {
        return {
            selected: false,
            videos: [],
        };
    },
    methods: {
        upload() {
            this.selected = true;

            //console.log(this.$refs.videos);
            this.videos = Array.from(this.$refs.videos.files);
            // this.$refs.videos.files ko phai la array that (ko dung dc map, filter) -> can convert qua array

            const uploaders = this.videos.map(video => {
                const form = new FormData();
                form.append('video', video);
                form.append('title', video.name);

                return axios.post(`/channels/${this.channel.id}/videos`, form);
            });
        }
    }
});