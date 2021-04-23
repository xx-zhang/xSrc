
/**
 * seajs配置
 */
seajs.config({
    
    // js目录设置
    base : "/static/v2.0/mobile/js",

    // 别名配置
    alias : {
        utils : 'modules/utils',
        editor : 'modules/editor'
    },
    
    // 各js模块文件命名控制，可用于调整时间戳参数和切换压缩版本
    map : [
        ['aixin.js', 'aixin.min.js?t=20160308'],
        ['blog.js', 'blog.min.js?t=20160308'],
        ['report.js', 'report.min.js?t=20170704'],
        ['shop.js', 'shop.min.js?t=20160308'],
        ['user.js', 'user.min.js?t=20160530'],
        ['utils.js', 'utils.min.js?t=20180209']
    ]
});
