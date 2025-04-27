module.exports = {
  outputDir: "dist",
  publicPath: process.env.NODE_ENV === "production" ? "/simple-bookmark/" : "/",
  devServer: {},
  chainWebpack: function (config) {
    config.plugin("html").tap(function (args) {
      args[0].title = "Simple Form Collection - Langnang"; // 自定义标题
      return args;
    });
  },
};
