require('./bootstrap');

window.Vue = require('vue');

const app =new Vue({
	el: '#app',
	methods: {

		onClick: function(event) {
			id = event.currentTarget.id;
			axios.post('http://localhost/chat/public/add', {id: id}).then(response => {
				location.reload();
			});
		},

		confirm: function(event) {
			id = event.currentTarget.id;
			axios.post('http://localhost/chat/public/accept', {id: id}).then(response => {
				location.reload();
			});
		},

		del: function(event) {
			id = event.currentTarget.id;
			axios.post('http://localhost/chat/public/delete', {id: id}).then(response => {
				location.reload();
			});
		},
	},
});

