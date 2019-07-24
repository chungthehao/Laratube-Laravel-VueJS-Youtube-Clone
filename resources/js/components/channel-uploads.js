
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
            progress: {},
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

                this.progress[video.name] = 0;
                return axios.post(
                    `/channels/${this.channel.id}/videos`,
                    form,
                    {
                        onUploadProgress: event => {
                            this.progress[video.name] = Math.ceil(event.loaded / event.total * 100);

                            // Force VueJS update nhung thay doi
                            this.$forceUpdate();
                        }
                    }
                );
            });
        }
    }
});