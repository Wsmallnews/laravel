
window._ = require('lodash');
// var fs = require('fs');
// var babel = require('babel-core');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');

/**
 * metisMenu 左侧菜单
 */
require('metismenu');
require('./sb-admin-2.js');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue/dist/vue.js');
require('vue-resource');
window.VueRouter = require('vue-router');       // 引入 vue-router

window.VueProgressBar = require('vue-progressbar'); // vue 进度条


/**
 * 网站异步访问，浏览器后退
 * @type {[type]}
 */
window.Pjax = require('pjax');      // 引入Pjax


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 * start echo pusher 实时通信，公共频道
 * @type {[type]}
 */
window.Pusher = require('pusher-js');

import Echo from "laravel-echo"

window.echo = new Echo({
    broadcaster: 'pusher',
    key: '0be6cdabf67ef8242444'
});


echo.channel('chat-room.1')
    .listen('ChatMessageWasReceived', function (data) {
        alert(data.chatMessage.message);
        // console.log(data.user, data.chatMessage);
    });
// end echo pusher 结束
