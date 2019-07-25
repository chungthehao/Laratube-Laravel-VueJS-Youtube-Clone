
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
            videos: [], // file list
            progress: {},
            uploads: [], // video return from server
            intervals: {}, // Muc dich de fetch % xu ly viec convert video
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
                ).then(res => {
                    const video = res.data;
                    this.uploads.push(video);
                });
            });

            // Sau khi upload xong cac video len server thi...
            axios.all(uploaders).then(() => {
                // Thay thế object video từ browser bằng kq video (db record) trả về từ server
                this.videos = this.uploads;

                // Set chu ky fetch record moi ve de co thong tin field 'percentage'
                this.videos.forEach(video => {
                    this.intervals[video.id] = setInterval(() => {
                        axios.get(`/videos/${video.id}`).then(({ data }) => {
                            // Neu da convert video xong thi thoi, xoa chu ky fetch di
                            if (data.percentage === 100) {
                                clearInterval(this.intervals[video.id]);
                            }

                            // Cap nhat vo this.videos de no co thong tin percentage moi nhat tu server
                            this.videos = this.videos.map(v => {
                                if (v.id === data.id) {
                                    return data;
                                }
                                return v;
                            });
                        });
                    }, 3000);
                });
            });
        }
    }
});