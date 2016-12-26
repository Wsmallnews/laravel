
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */
// 全局注册
Vue.component('no-data', require('./components/admincms/no-data.vue'));
// 引入，等待局部注册
window.example = require('./components/Example.vue');
window.admin_table = require('./components/admincms/table.vue');

/**
 * 初始化vue进度条
 * @type {Object}
 */
const options = {
    color: '#2196f3',
    failedColor: '#b31c2f',
    thickness: '3px',
    transition: {
        speed: '0.2s',          // 速度
        opacity: '0.3s'         // 消失速度
    },
    autoRevert: true,
    location: 'top',
    inverse: false
}

Vue.use(VueProgressBar, options);


/**
 * 初始化 Pjax，选择元素 a  绑定区域整个body
 */
document.addEventListener("DOMContentLoaded", function() {
    new Pjax({
        elements: ".pjax-element",
        selectors: ["title", "#page-wrapper", ".pjax-script"]
    });
});


/**
 * 监听pjax 请求 显示滚动条
 * @type {[type]}
 */
document.addEventListener("pjax:send", function() {
    Vm.$Progress.start();
})
document.addEventListener("pjax:complete", function() {
})
document.addEventListener("pjax:error", function() {
    Vm.$Progress.fail();
})
document.addEventListener("pjax:success", function() {
    Vm.$Progress.finish();
})


/**
* We'll register a HTTP interceptor to attach the "CSRF" header to each of
* the outgoing requests issued by this application. The CSRF middleware
* included with Laravel will automatically verify the header's value.
*/
document.addEventListener("DOMContentLoaded", function() {
    Vue.http.interceptors.push((request, next) => {
        if(Vm.$Progress.state.timer == null){       // 如果当前没有进度条，就显示进度条
            Vm.$Progress.start();
        }
        
        request.headers['X-CSRF-TOKEN'] = Laravel.csrfToken;

        next((response)=>{
            if(response.ok){
                Vm.$Progress.finish();
            }else{
                Vm.$Progress.fail();
            }
        });
    });
});




