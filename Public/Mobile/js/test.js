// test.js

// 目录：
// 1. 处理兼容的代码
    // 1.1. 弹窗水平垂直居中，获取 height，设置 margin-top
// 2. 页面效果代码
    // 2.1. 顶部导航栏 scroll 代码
// 3. 测试用代码
    // 3.1. 模拟弹窗点击关闭交互
    // 3.2. 组件展示页，组件展示

;(function() {
    'use strict';

// 1. 处理兼容的代码
    // 1.1. 弹窗水平垂直居中，获取 height，设置 margin-top


// 2. 页面效果代码
    // 2.1. 顶部导航栏 scroll 代码

    // $(window).scroll(function () {
    //     if($(this).scrollTop() > 88) {
    //         $('.header').addClass('header-scroll');
    //     } else {
    //         $('.header').removeClass('header-scroll');
    //     }
    // });



// 3. 测试用代码
    // 3.1. 模拟弹窗点击关闭交互

    // 「提交漏洞」-提交弹窗
    (function() {
        var reportContainer = document.getElementsByClassName('container-report')[0];
        if (!reportContainer) { return; }

        $('.mod-btn-blue').on('click', function(e) {
            e.preventDefault();
            $('.mod-popup-report').addClass('mod-popup-show');
        });
    })();

    // 「商品下单」&&「个人中心-我的个人信息-信息详情」&&「个人中心-我的个人信息-申请TSRC中国网络精英卡」-添加地址弹窗
    (function() {
        $('.mod-address-add').on('click', function(e) {
            e.preventDefault();
            $('.mod-popup-address').addClass('mod-popup-show');
        });
    })();

    // 「公益」 -爱心捐赠

    (function() {
        var $mod_popup_donate_confirm = $('.mod-popup-donate-confirm');
        $('.rightblock_submit').on('click', function(e) {
            e.preventDefault();
            $mod_popup_donate_confirm.addClass('mod-popup-show');
        });
        $mod_popup_donate_confirm.on('click', '.mod-btn-blue', function(e) {
            e.preventDefault();
            $mod_popup_donate_confirm.removeClass('mod-popup-show');
            $('.mod-popup-donate-success').addClass('mod-popup-show');
        });

        var $mod_popup_donate = $('.mod-popup-donate');
        $('.article_body').on('click', '.mod-btn-blue', function(e) {
            e.preventDefault();
            $mod_popup_donate.addClass('mod-popup-show');
        });
        $mod_popup_donate.on('click', '.mod-btn-blue', function(e) {
            e.preventDefault();
            $mod_popup_donate.removeClass('mod-popup-show');
            $('.mod-popup-donate-success').addClass('mod-popup-show');
        });

    })();


    // 「关于我们」-申请职位弹窗
    (function() {
        $('.mod-itemlist-joinus').on('click', '.itemlist_item', function(e) {
            e.preventDefault();
            $('.mod-popup-joinus').addClass('mod-popup-show');
        });
    })();

    // 「我的个人中心-消息中心」-点击消息弹窗
    (function() {
        $('.mod-sheet-user-message').on('click', 'a', function(e) {
            e.preventDefault();
            $('.mod-popup-message').addClass('mod-popup-show');
        });
    })();

    // 「我的个人中心-我的礼品-礼品详情」-点击确认收货
    (function() {
        $('.body_block-confirm').on('click', '.mod-btn', function(e) {
            e.preventDefault();
            $('.mod-popup-confirm').addClass('mod-popup-show');
        });
    })();


    // 3.2. 组件展示页，组件展示
    $('#mod-btn-confirm').on('click', function(e) {
        e.preventDefault();
        $('.mod-popup-confirm').addClass('mod-popup-show');
    });
    $('#mod-btn-report').on('click', function(e) {
        e.preventDefault();
        $('.mod-popup-report').addClass('mod-popup-show');
    });
    $('#mod-btn-donate').on('click', function(e) {
        e.preventDefault();
        $('.mod-popup-donate').addClass('mod-popup-show');
    });
    $('#mod-btn-donate-confirm').on('click', function(e) {
        e.preventDefault();
        $('.mod-popup-donate-confirm').addClass('mod-popup-show');
    });
    $('#mod-btn-address').on('click', function(e) {
        e.preventDefault();
        $('.mod-popup-address').addClass('mod-popup-show');
    });
    $('#mod-btn-joinus').on('click', function(e) {
        e.preventDefault();
        $('.mod-popup-joinus').addClass('.mod-pop-show');
    });
    $('#mod-btn-message').on('click', function(e) {
        e.preventDefault();
        $('.mod-popup-message').addClass('mod-popup-show');
    });

    // 点击「遮罩层」或者「关闭按钮」关闭所有弹窗
    $('.popup_mask').on('click', function(e) {
        e.preventDefault();
        $('.mod-popup').removeClass('mod-popup-show');
    });
    $('.i-close').on('click', function(e) {
        e.preventDefault();
        $('.mod-popup').removeClass('mod-popup-show');
    });
    $('.mod-btn-close').on('click', function(e) {
        e.preventDefault();
        $('.mod-popup').removeClass('mod-popup-show');
    });


    /*
       # 按照宽高比例设定html字体
       # 说明：
          - baseWidth和baseHeiht是设计稿尺寸
          - baseFontSize是720设计稿下html的fontsize
          - 按照当前屏幕宽高比跟设计稿宽高比较小的值作为缩放比例
    */
     // function setHtmlFontSize(callback) {
     //   // var baseWidth = 720, baseHeiht = 1280, baseFontSize = 100, newSize = 100,sacle = 1;
     //     var baseWidth = 375, baseHeight = 591, baseFontSize = 10, newSize = 100, scale = 1;


     //     var doc = window.document;
     //     var docEl = doc.documentElement;
     //     var width = docEl.getBoundingClientRect().width;

     //     console.log(document.body.clientWidth);
     //     console.log(window.innerWidth);
     //     console.log(width);

     //    //如果此时屏幕宽度不准确，就尝试再次获取分辨率，只尝试10次，否则使用innerWidth计算
     //     if(document.body.clientWidth !== window.innerWidth && count < 10) {
     //         document.body.style.display = "none";
     //         window.setTimeout(setHtmlFontSize, 0);
     //         count++;
     //     } else {
     //         var scale = Math.min(window.innerWidth / baseWidth, window.innerHeight / baseHeight), newSize = parseInt( scale * 10000 * baseFontSize ) / 10000;

     //         document.body.style.display = "none";
     //         setTimeout(function() {
     //             document.body.style.display = "";
     //             if(callback) {
     //                 callback();
     //             }
     //             document.documentElement.style.fontSize = newSize + "px";
     //         }, 0);
     //         console.log(newSize);
     //     }
     // }
     // setHtmlFontSize();
})();




