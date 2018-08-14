require('./bootstrap');

window.Vue = require('vue');

//new
Vue.component('chat-messages', require('./components/ChatMessages.vue'));

Vue.component('chat-form', require('./components/ChatForm.vue'));

const app = new Vue({
    el: '#chat',

    data: {
        messages: [],
    },

    created() {
        this.fetchMessages();
        Echo.private(room)
        .listen('MessageSent', (e) => {
          this.messages.push({
            message: e.message.message,
            user: e.user
        });
      });
    },

    methods: {
        fetchMessages() {
            axios.get('http://localhost/chat/public/messages').then(response => {
                this.messages = response.data;
            });
        },

        addMessage(message) {
            this.messages.push(message);
            axios.post('http://localhost/chat/public/messages', message).then(response => {
            });
        },
    }

});