// main.js  页面效果


// 博客列表页，轮播图
var swiper = new Swiper('.swiper-container-blog', {
    pagination: '.swiper-pagination',
    paginationClickable: true
});
// 首页-贡献榜-轮播
var swiper = new Swiper('.swiper-container-rank', {
    pagination: '.swiper-pagination',
    initialSlide: 1,
    effect: 'coverflow',
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: 'auto',
    loop: true,
    loopedSlides: 3,
    coverflow: {
        rotate: 0,
        stretch: -120,
        depth: 400,
        modifier: 1,
        slideShadows : false
    }
});



var $header = $('.header');

// 顶部导航栏滚动效果
$(window).scroll(function () {
    if(!$header.hasClass('header-dropdown')) {
        if($(this).scrollTop() > 50) {
            $header.addClass('header-scroll');
        } else {
            $header.removeClass('header-scroll');
        }
    }
});
// 顶部左侧导航栏点击效果
$('.main_menuicon').on('click', function(e) {
    e.preventDefault();
    $header.hasClass('header-dropdown') ? $header.removeClass('header-dropdown') : $header.addClass('header-dropdown');
});
