import numeral from 'numeral';

Vue.component('subscribe-button', {
    props: {
        channel: {
            type: Object,
            required: true,
            default: () => ({}) // Default is an empty object
        },
        subscriptions: {
            type: Array,
            required: true,
            default: () => [] // Default is an empty array
        }
    },
    computed: {
        subscribed() {
            // Nếu chưa login hoặc
            // login r mà là owner của channel này hoặc
            // login r mà ko phải this channel's subscriber --> false
            if ( ! __auth() || __auth().id === this.channel.user_id) return false;
            return !! this.subscriptions.find(subscription => subscription.user_id === __auth().id);
            // (!!) cast to boolean
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
            if ( ! __auth()) alert('Please login to subscribe!');
        }
    }
});