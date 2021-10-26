    import Vue from 'vue'
    // import VueRouter from 'vue-router'
    // Vue.use(VueRouter)

    import App from './views/App'
    import Welcome from './views/Welcome'
    import Mycom from './views/Mycom'
    //import Paginate from './views/Paginate'

    //export default Paginate
    /* 
        const router = new VueRouter({
        mode: 'history',
        routes: [
        {
        path: '/',
        name: 'home',
        component: Welcome
        },
        {
        path: '/alex',
        name: 'alex',
        component: Mycom
        }
        ],
        });
    */

    //Vue.component('paginate', Paginate)

    const app = new Vue({
        el: '#app',
        components: { App,Mycom },
        data: {
            alex:{},
            posts: {},
            pagination: {
                'current_page': 1
            },
            name: 'Vue.js',           
        },    
        methods: {
            fetchPosts() {
                axios.get('paginate?page=' + this.pagination.current_page)
                    .then(response => {
                        console.log(response.data.data.data)
                        this.posts = response.data.data.data;
                        this.pagination = response.data.pagination;
                    })
                    .catch(error => {
                        console.log(error.response.data);
                    });
            },
            greet: function (event) {
                axios.get('onclick?page=id' )
                .then(response => {
                    $("#order_status_contactus").modal('show');  
                   this.alex = response.data;                
                    console.log(response.data.html)
                })
                .catch(error => {                   
                });
            },
            sendme: function(){
                alert('this is very awesome hehe and huge project haha');
            }             
        },    
        mounted() {
           // this.fetchPosts();
        }
    });