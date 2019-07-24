import numeral from 'numeral';

Vue.component('subscribe-button', {
    props: {
        channel: {
            type: Object,
            required: true,
            default: () => ({}) // Default is an empty object
        },
        initialSubscriptions: {
            type: Array,
            required: true,
            default: () => [] // Default is an empty array
        }
    },
    data() {
        return {
            subscriptions: this.initialSubscriptions,
        };
    },
    computed: {
        subscribed() {
            // Nếu chưa login hoặc
            // login r mà là owner của channel này hoặc
            // login r mà ko phải this channel's subscriber --> false
            if ( ! __auth() || __auth().id === this.channel.user_id) return false;
            return !! this.subscription;
            // (!!) cast to boolean
        },
        subscription() {
            if ( ! __auth()) return null;
            return this.subscriptions.find(subscription => subscription.user_id === __auth().id);
        },
        owner() {
            return __auth() && __auth().id === this.channel.user_id;
        },
        totalSubscribers() {
            return numeral(this.subscriptions.length).format('0a');
        }
    },
    methods: {
        toggleSubscription() {
            if ( ! __auth()) return alert('Please login to subscribe!');

            if (this.owner) return alert('You can NOT subscribe to your channel!');

            if (this.subscribed) {
                // Thuc hien viec unsubscribe
                axios
                    .delete(`/channels/${this.channel.id}/subscriptions/${this.subscription.id}`)
                    .then(res => {
                        console.log(res.data);
                        const index = this.subscriptions.findIndex(subscription => subscription.id === res.data.id);
                        if (index > -1) {
                            this.subscriptions.splice(index, 1);
                        }
                    })
                    .catch(err => console.log(err.response.data));
            } else {
                // Thuc hien viec subscribe
                axios
                    .post(`/channels/${this.channel.id}/subscriptions`)
                    .then(res => {
                        console.log(res.data);
                        this.subscriptions.push(res.data);
                    })
                    .catch(err => console.log(err.response.data));
            }
        }
    }
});