module.exports = {
    configureWebpack: {
        resolve: {
            alias: {
                // vue: "vue/dist/vue.esm.js", //加上这一句
            }
        },
        devServer: {
            proxy: {
                '/access_token': {
                    target: 'https://github.com/login/oauth/access_token',
                    // 允许跨域
                    changeOrigin: true,
                    // ws: true,
                    pathRewrite: {
                        '^/access_token': ''
                    }
                }
            }
        }
    },
    outputDir: 'dist',
    publicPath: process.env.NODE_ENV === 'production'
        ? '/QuestionAwesome/'
        : '/',
    chainWebpack: config => {
        config
            .plugin('html')
            .tap(args => {
                args[0].title = 'Question Awesome'
                return args
            })
    },

}