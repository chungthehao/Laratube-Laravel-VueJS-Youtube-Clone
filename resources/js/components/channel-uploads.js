
Vue.component('channel-uploads', {
    data() {
        return {
            selected: false
        };
    },
    methods: {
        upload() {
            this.selected = true;

            //console.log(this.$refs.videos);
            const videos = this.$refs.videos.files;

            console.log(videos);
        }
    }
});