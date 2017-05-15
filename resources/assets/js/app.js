
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
        selectors: ["title", "#page-wrapper", "#page-body", ".pjax-script"]
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


/**
 * vue  marked  插件配置
 * @type {marked}
 */
marked.setOptions({
    renderer: new marked.Renderer(),
    gfm: true,
    tables: true,
    breaks: false,
    pedantic: false,
    sanitize: false,
    smartLists: true,
    smartypants: false
});


/** 
 * 设置 textarea 自动随内容增高
 */
autosize($(".autosize"));       


/**
 * 弹框   sweetalert
 */
window.showAlert = function(obj, confirmCB, cancelCB){
    var defaults = {
        title: "",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        closeOnConfirm: false,
        closeOnCancel: false
    };
    
    $.extend(defaults, obj);
    
    swal(defaults,function(isConfirm){
        if (isConfirm) {
            if(confirmCB != undefined){
				confirmCB();
                return;
			}
            swal("this is confirm", '', 'success');
            
        } else {
            if(cancelCB != undefined){
                cancelCB();
                return;
            }
            swal.close();
        }
    });
}



/**
 * 重新定义 SimpleMDE 编辑器
 */
window.MDEditor = function(options){
    var defaults = {  // 默认参数
        element: "",
        // autosave: {      // 如有需要，可自行设置
        //     enabled: true,
        //     uniqueId: "MyUniqueID",
        //     delay: 1000,
        // },
        initialValue : "",      // 默认值
        forceSync : false,       // 内容变动时是否强制 写到原本textarea 框
        autoDownloadFontAwesome: false,         // 是否强制下载Font Awesome，因为已经引入，所以设置为false
        placeholder:"请使用 Markdown 格式书写(≧∇≦)",
        promptURLs: false,          //插入图片，弹出 prompt 框输入 url
        tabSize: 4,
        // toolbar:false,               // 隐藏工具栏
        toolbarTips: false
    };
    
    $.extend(defaults, options);
    
    return new SimpleMDE(defaults);
}


/**
 * 定义拖拽 粘贴上传图片
 */
window.MDUploader = function(editor_obj, options){
    var defaults = {
        uploadUrl: "",
        uploadFieldName: "FileContent",
        urlText: "\n ![file]({filename}) \n\n",
        extraParams: {
            '_token': Laravel.csrfToken
        }
    };
    
    $.extend(defaults, options);
    
    defaults.uploadUrl = (defaults.uploadUrl == undefined || defaults.uploadUrl == '') ? 
                        Laravel.uploadUrl : defaults.uploadUrl;
    
    inlineAttachment.editors.codemirror4.attach(editor_obj, defaults);
}


/**
 * 重新定义 webuploader 图片上传
 * @author @smallnews 2017-04-20
 * @param  {[type]} options    [description]
 * @param  {[type]} upload_obj [description]
 * @return {[type]}            [description]
 */
window.MyUploader = function(options, upload_obj){
    var defaults = {
        dnd: true,
        // swf: 'path_of_swf/Uploader.swf',
        pick: upload_obj,
        formData: {_token: Laravel.csrfToken},
        server: '',
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        },
        auto: true,
        // 开起分片上传。
        chunked: true,          // 开启分片上传
        chunkSize: 5242880,     // 分片大小
        chunkRetry: 2,          // 分片上传失败重试次数
        fileVal: 'FileContent',        // 文件表单名称
        method: 'POST',         // 方式
        fileNumLimit: 5,        // 验证上传数量是否超过限制
        fileSingleSizeLimit: 5242880,        // 验证单个文件大小是否超过限制
        startUpload: function (){},                         // 开始上传流程是触发
        uploadStart: function (file){},                     // 上传开始前
        uploadProgress: function (file, percentage){},      // 上传中方法
        uploadSuccess: function (file){},                       // 文件上传成功
        uploadComplete: function (file){uploader.reset();},                      // 文件上传完成，不管成功失败
        uploadError: function (file){}                         // 文件上传出错
    };

    // 把 defaults 的formData 合并到 options
    if (options != undefined && options.formData != undefined) {
        $.extend(options.formData, defaults.formData);
    }
    
    // 把 options 合并到 defaults
    $.extend(defaults, options);
    
    defaults.server = (defaults.server == undefined || defaults.server == '') ? 
                        Laravel.uploadUrl : defaults.server;
    
    var uploader = WebUploader.create(defaults);
    uploader.on('startUpload', defaults.startUpload);
    uploader.on('uploadStart', defaults.uploadStart);     
    uploader.on('uploadProgress', defaults.uploadProgress);
    uploader.on('uploadSuccess', defaults.uploadSuccess);
    uploader.on('uploadComplete', defaults.uploadComplete);
    uploader.on('uploadError', defaults.uploadError);
    
    uploader._this = upload_obj;
    
    return uploader
}


// 全局注册,admincms
Vue.component('admin-no-data', require('./components/admincms/no-data.vue'));

// 全局注册 desktop
Vue.component('markdown', require('./components/markdown.vue'));
Vue.component('uploader', require('./components/uploader.vue'));
// Vue.component('desk-no-data', require('./components/desktop/no-data.vue'));

// 局部注册 admincms
// window.example = require('./components/Example.vue');
window.admin_table = require('./components/admincms/table.vue');

// 局部注册 desktop
// window.md_desk = require('./components/markdown.vue');

const Vm = new Vue({
    el: '#wrapper'
});



/**
 * 百度统计代码
 */
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?0d4d8ef8221b70abfd4951252162a63b";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();


