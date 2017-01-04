<template>
<div class="rows">
    <div class="form-group" v-bind:class="{'has-error': hasError}">
        <textarea class="form-control autosize" id="md-content" v-model="taBody" placeholder="请使用 Markdown 格式书写(≧∇≦)" name="body" rows="10" cols="50"></textarea>
        
        <span class="help-block" v-if="hasError">
            <strong>{{ errorMsg }}</strong>
        </span>
        
    </div>
    
    <div class="form-group">
        <div class="form-control pd-10" v-bind:class="{ hidden: isHidden }" id="md-html" v-html="mdContent"></div>
    </div>
</div>
    
</template>

<script>
    export default {
        props : [
            'taContent',
            'hasError',
            'errorMsg'
        ],
        data : function (){
            return {
                'taBody' : this.taContent
            }
        },
        computed: {
            mdContent : function(){
                return marked(this.taBody);
            },
            isHidden : function(){
                return this.taBody == '' ? true : false;
            }
        }
    }
</script>
