const path = require("path");
const terser = require("terser-webpack-plugin");
module.exports = {
  mode: "production",
  devtool: "eval-source-map",
  entry: path.join(__dirname, "src/index.js"),
  output: {
    library: "Snabbdom",
    libraryTarget: "umd",
    libraryExport: "default",
    publicPath: "dist",
    filename: "snabbdom.js",
  },
  devServer: {
    // port: 8080,
    // contentBase: "examples",
  },
  module: {
    rules: [
      {
        test: "/.js$/",
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: "babel-loader",
          options: {
            presets: "babel-presets-env",
            plugins: [require("babel-plugin-transform-runtime"), require("babel-plugin-transform-remove-console")],
          },
        },
      },
    ],
  },
  optimization: {
    minimizer: [
      new terser({
        terserOptions: {
          output: {
            comments: false, // 此配置最重要，无此配置无法删除声明注释
          },
          format: {
            comments: false,
          },
        },
        extractComments: false,
      }),
    ], // 替换js压缩默认配置
  },
};
