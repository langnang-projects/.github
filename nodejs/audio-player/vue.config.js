module.exports = {
  outputDir: "dist",
  publicPath:
    process.env.NODE_ENV === "production" ? "/simple-audio-player/" : "/",
  devServer: {
    port: 8080, // 自定义端口
    proxy: {
      "/music.163": {
        target: "https://music.163.com", // 你请求的第三方接口
        changeOrigin: true, // 在本地会创建一个虚拟服务端，然后发送请求的数据，并同时接收请求的数据，这样服务端和服务端进行数据的交互就不会有跨域问题
        pathRewrite: {
          // 路径重写，
          "^/music.163": "" // 替换target中的请求地址
        }
      },
      // interface3.music.163
      "/interface3.music.163": {
        target: "https://interface3.music.163.com", // 你请求的第三方接口
        changeOrigin: true, // 在本地会创建一个虚拟服务端，然后发送请求的数据，并同时接收请求的数据，这样服务端和服务端进行数据的交互就不会有跨域问题
        pathRewrite: {
          // 路径重写，
          "^/interface3.music.163": "" // 替换target中的请求地址
        }
      },
      "/music.kugou": {
        target: "https://m.kugou.com", // 你请求的第三方接口
        changeOrigin: true, // 在本地会创建一个虚拟服务端，然后发送请求的数据，并同时接收请求的数据，这样服务端和服务端进行数据的交互就不会有跨域问题
        pathRewrite: {
          // 路径重写，
          "^/music.kugou": "" // 替换target中的请求地址
        }
      }
    }
  },
  chainWebpack: config => {
    config.plugin("html").tap(args => {
      args[0].title = "Simple Audio Player - Langnang"; // 自定义标题
      return args;
    });
  }
};
