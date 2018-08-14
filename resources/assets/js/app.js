
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 require('./bootstrap');

 window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component('home-page',require('./components/HomePage.vue'));

var room = document.getElementById("room").value;

const app = new Vue({
    el: '#search',
    data: {
        users: [],
    },

    methods: {
        submit(event){
            name = event.target.value;
            axios.post('http://localhost/chat/public/search', {name: name}).then(response => {
                document.getElementById('app').style.display = 'none';
                var myNode = document.getElementById("sea");
                myNode.innerHTML = '';
                response.data.forEach(function(item){
                    var card = document.createElement("div");
                    var cardheader = document.createElement("div");
                    var nodea = document.createElement("a");
                    var textnode = document.createTextNode(item['name']);
                    var textnode1 = document.createTextNode(item['email']);      
                    nodea.appendChild(textnode);
                    card.appendChild(cardheader);
                    cardheader.appendChild(nodea);
                    var h1 = document.createElement("h1");
                    h1.appendChild(textnode1);
                    card.appendChild(h1);
                    card.classList.add("card");
                    cardheader.classList.add("card-header");
                    document.getElementById("sea").appendChild(card);
                });
            });
        },
    }

});
