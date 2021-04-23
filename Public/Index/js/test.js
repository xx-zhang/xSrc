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

    $(window).scroll(function () {
        if($(this).scrollTop() > 80) {
            $('.header').addClass('header-scroll');
        } else {
            $('.header').removeClass('header-scroll');
        }
    });



// 3. 测试用代码
    // 3.1. 模拟弹窗点击关闭交互

    // 「提交漏洞」-提交弹窗
    /**(function() {
        var reportContainer = document.getElementsByClassName('container-report')[0];
        if (!reportContainer) { return; }
        var btnEl = reportContainer.querySelector('form .mod-btn-blue');
        var popupEl = document.querySelector('.mod-popup');

        btnEl.addEventListener('click', function(e) {
            e.preventDefault();
            popupEl.style.display = 'block';
        });
    })();**/

    // 「商品下单」&&「个人中心-我的个人信息-信息详情」&&「个人中心-我的个人信息-申请TSRC中国网络精英卡」-添加地址弹窗
    (function() {
        $('#add_address_button').on('click', function(e) {
            e.preventDefault();
            $('#add_address_div').show();
        });
    })();

    // 「公益」 -爱心捐赠

    (function() {
        var $mod_popup_donate_confirm = $('.mod-popup-donate-confirm');
        $('.rightblock_submit').on('click', function(e) {
            e.preventDefault();
            $mod_popup_donate_confirm.show();
        });
        $mod_popup_donate_confirm.on('click', '.mod-btn-blue', function(e) {
            e.preventDefault();
            $mod_popup_donate_confirm.hide();
            $('.mod-popup-donate-success').show();
        })

        var $mod_popup_donate = $('.mod-popup-donate');
        $('.article_body').on('click', '.mod-btn-blue', function(e) {
            e.preventDefault();
            $mod_popup_donate.show();
        });
        $mod_popup_donate.on('click', '.mod-btn-blue', function(e) {
            e.preventDefault();
            $mod_popup_donate.hide();
            $('.mod-popup-donate-success').show();
        });

    })();


    // 「关于我们」-申请职位弹窗
    (function() {
        $('.mod-itemlist-joinus').on('click', '.itemlist_item', function(e) {
            e.preventDefault();
            $('.mod-popup-joinus').show();
        });
    })();

    // 「我的个人中心-消息中心」-点击消息弹窗
    (function() {
        $('.table_message').on('click', 'a', function(e) {
            e.preventDefault();
            $('.mod-popup-message').show();
        });
    })();

    // 「我的个人中心-我的礼品-礼品详情」-点击确认收货
    (function() {
        $('.body_block-confirm').on('click', '.mod-btn', function(e) {
            e.preventDefault();
            $('.mod-popup-confirm').show();
        });
    })();


    // 3.2. 组件展示页，组件展示
    $('#mod-btn-confirm').on('click', function(e) {
        e.preventDefault();
        $('.mod-popup-confirm').show();
    });
    $('#mod-btn-report').on('click', function(e) {
        e.preventDefault();
        $('.mod-popup-report').show();
    });
    $('#mod-btn-donate').on('click', function(e) {
        e.preventDefault();
        $('.mod-popup-donate').show();
    });
    $('#mod-btn-donate-confirm').on('click', function(e) {
        e.preventDefault();
        $('.mod-popup-donate-confirm').show();
    });
    $('#mod-btn-address').on('click', function(e) {
        e.preventDefault();
        $('.mod-popup-address').show();
    });
    $('#mod-btn-joinus').on('click', function(e) {
        e.preventDefault();
        $('.mod-popup-joinus').show();
    });
    $('#mod-btn-message').on('click', function(e) {
        e.preventDefault();
        $('.mod-popup-message').show();
    });

    // 点击「遮罩层」或者「关闭按钮」关闭所有弹窗
    $('.popup_mask').on('click', function(e) {
        e.preventDefault();
        $('.mod-popup').hide();
    });
    $('.i-close').on('click', function(e) {
        e.preventDefault();
        $('.mod-popup').hide();
    });
    $('.mod-btn-close').on('click', function(e) {
        e.preventDefault();
        $('.mod-popup').hide();
    });
})();




