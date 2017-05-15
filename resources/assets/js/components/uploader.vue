<template>
<div class="rows">
    <div class="img-file shadow" v-bind:class="{ hidden: isHidden }" :style="background">
        <input type="hidden" v-bind:name="btnObj" v-model="inputValue" >
        <div class="progress"></div>
    </div>
    <div class="shadow edit-img" v-bind:id="btnObj">{{btnName}}</div>
    <div class="clear"></div>
</div>
    
</template>

<script>
    export default {
        props : [
            'btnObj',
            'type',
            'defValue',
            'uploadUrl',
            'btnName'
        ],
        data : function (){
            return {
                'inputValue' : this.defValue
            }
        },
        computed: {
            isHidden : function(){
                return this.inputValue == '' ? true : false;
            },
            background: function(){
                return "background-image: url(" + this.inputValue + "?imageView2/5/w/200);background-size:cover";
            }
        },
        mounted: function(){
            var _this = this;
            var uploader = MyUploader({
                formData: {'file_type': this.type},
                server: this.uploadUrl,
                uploadStart: function(){
                    uploader.btn_obj = $(uploader._this);   // 上传按钮 $ 对象
                    uploader.img_obj = uploader.btn_obj.siblings('.img-file');  // img 对象
                    uploader.img_obj.show();       // 显示 img 框
                },
                uploadProgress: function (file, percentage){
                    var percent = parseInt(parseFloat(percentage) * 100);
                    uploader.img_obj.find('.progress').css({width:percent+"%"});
                },
                uploadSuccess: function (file, response){
                    var data = response.data;
                    
                    _this.inputValue = data.url;
                    uploader.img_obj.find('.progress').css({width: 0});
                    
                    _this.background = "background-image: url(" + data.url + "?imageView2/5/w/200);background-size:cover";
                    // uploader.img_obj.css({'background-image': "url("+data.url+});
                }
            }, "#" + _this.btnObj);
        }
    }
</script>
