
(function($){
    var PopUpWin = function(ele,opts){
        opts = $.extend({
            id:'',
            content:undefined,//内容
            closeCallback:undefined//关闭时调用的方法
        },opts);
        this.init(ele,opts);
    }

    PopUpWin.prototype = {
        template:'<div class="pop-wraper" id="{id}">\
                <div class="pop-outer">\
                    <div class="pop-inner">\
                        <div class="pop-content">\
                            {content}\
                        </div>\
                        <div class="btn btn_cancel"><i class="ico_cancel"></i></div>\
                    </div>\
                </div>\
            </div>',
        init:function(ele,opts){
            this.render(ele,opts);
            this.initEvent(ele,opts);
        },
        initEvent:function(ele,opts){
            var self = this;
            ele.find('.btn_cancel').click(function(){
                ele.find('#'+self.id).remove();
                if(opts.closeCallback !== undefined && $.isFunction(opts.closeCallback)){
                    opts.closeCallback();
                }
            });
        },
        elId:function(){//自动生成7位8进制DOM元素ID
            return 'win-xxx'.replace(/[x]/g,function(c){
                var r = Math.random() * 16|0, v = c === 'x' ? r : (r&0x3|0x8);
                return v.toString(8);
            }).toLocaleLowerCase();
        },
        render:function(ele,opts){
            if(ele === undefined){
                ele = $('body');
            }
            
            var content = opts.content;
            this.id = this.elId();
            
            if($.isFunction(content)){
                content  = content(this);
            }
                tpl = this.template.replace(/\{id\}/,this.id).replace(/\{content\}/,content);
            ele.append(tpl);
        }
    };

    $.fn.popUpWin = function(opts){
        return this.each(function(){
             var that = $(this);
             var popUp = new PopUpWin(that,opts);
        });
    };

})(jQuery);



(function(win,$,h){
    $(document).ready(function(){
          var routeUrl = {
            'orderInfo':'order.html',//订单提交页面
            'orderInfo_method':'submitOrderInfo',//订单提交action方法
            'queryOrder':'queryOrder.html',
            'queryOrder_method':'queryOrder',
            'refundTest':'refundTest.html',
            'refundTest_method':'submitRefund',
            'queryRefund':'queryRefund.html',
            'queryRefund_method':'queryRefund'
        }, validateField = {//需要验证的字段
            'orderInfo':['out_trade_no','body','total_fee','mch_create_ip'],//字段名
            'orderInfo_msg':['商户订单号','商品描述','总金额','终端IP'],//字段对应的中文名
            'refundTest':['out_refund_no','total_fee','refund_fee'],
            'refundTest_msg':['商户退款单号','总金额','退款金额']
        },loadHtml = function(url,suffix){
            $('#auto_center').empty().load(url+' #'+suffix,function(tpl, status, obj){
                console.log('tpl:::;',tpl,status,obj);
                $('#auto_center').html(tpl);
                if(suffix === 'orderInfo'){
                    $('input[name=out_trade_no]').val((''+Math.random() * 10).substr(2));
                }else if(suffix === 'refundTest'){
                    $('input[name=out_refund_no]').val((''+Math.random() * 10).substr(2));
                }
            });
        }, curPage = 'orderInfo',
        number = /^(\d?)/g,ip = /^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})/g,
        time = /^(\d{14})?/;
        //初始化加载的页面
        loadHtml(routeUrl['orderInfo'],'orderInfo');
        
        

        $('div.menu li').bind('click',function(e){
            var curTarget = $(e.currentTarget), href = curTarget.attr('href'),suffix = href.substring(href.lastIndexOf('\.'));
            curTarget.addClass('cur').siblings('.cur').removeClass('cur');
            loadHtml(routeUrl[href],suffix);
            curPage = suffix;
        });

        $('#pay_platform').delegate('span','click',function(e){
            if(e.target.className.indexOf('submit') === -1){
                return;
            }

            var input = $('div.form_wrap').find('input,select'), param = {method:'submitOrderInfo'}, vField = validateField[curPage];
            input.each(function(i,item){
                item = $(item);
                var vType = item.attr('vtype'), ind = 0;
                param[item.attr('name')] = item.val();
            });

            //判断不能为空的字段
            if(vField !== undefined){
                for(var i=0, field='', msg = ''; i<vField.length; i++){
                    field = vField[i];
                    msg = validateField[curPage+'_msg'][i];
                    if(param[field] === ''){
                        $('body').popUpWin({
                            content:msg+'不能为空！'
                        });
                        return;
                    }
                }
            }
            //设计提交方法
            param['method']=routeUrl[curPage+'_method'];

            var mask = $('<div class="mask"></div>');
                $('body').append(mask);
            $.post('request.php',param,function(res){
                $('body').find('.mask').remove();
                if(typeof(res) === 'string'){
                    res = JSON.parse(res);
                }
				
                if(res.status === 500){
                    _content = res.msg;
                    $('body').popUpWin({
                        content:res.msg
                    });
                }else{
                    if(curPage === 'orderInfo'){
                        if (res.is_raw == '0') {
                            window.location.href = 'https://pay.swiftpass.cn/pay/jspay?token_id='+res.token_id+'&showwxtitle=0';
                        } else if (res.is_raw == '1') {
                           /* $('body').popUpWin({
                            content: '请将此json串作为本地原生js函数的参数传递' + res.pay_info
                            });*/
                            var value = JSON.parse(res.pay_info);
                            var temp = {};
                            temp.appId = value.appId;
                            temp.timeStamp = value.timeStamp;
                            temp.nonceStr = value.nonceStr;
                            temp.package = value.package;
                            temp.signType = value.signType;
                            temp.paySign = value.paySign;
                            
                            function onBridgeReady(){
                               WeixinJSBridge.invoke(
                                   'getBrandWCPayRequest', temp,
                                    function(res){     
                                       if(res.err_msg == "get_brand_wcpay_request:ok" ) {
                                        window.location.href = 'http://www.swiftpass.cn';
                                       }     // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。 
                                   }
                               ); 
                            }
                            if (typeof WeixinJSBridge == "undefined"){
                               if( document.addEventListener ){
                                   document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
                               }else if (document.attachEvent){
                                   document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
                                   document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
                               }
                            }else{
                               onBridgeReady();
                            }
                        }
                    }else{
                        $('body').popUpWin({
                            content:res.msg
                        });
                    }
                }

                
            });
        });
    });
})(window,jQuery);
