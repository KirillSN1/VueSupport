const path = require('path');
const { VueLoaderPlugin } = require('vue-loader');

module.exports = {
  mode: process.env.NODE_ENV,
  entry: './resources/js/app.js',
  output: {
    path: path.resolve(__dirname, 'public/js'),
    filename: 'app.generated.js',
  },
  resolve: {
    alias: {
      vue: 'vue/dist/vue.js'
    },
  },
  module: {
    rules: [
      {
        test:/\.vue$/,
        loader: 'vue-loader'
      },
      {
        test: /\.js$/,
        use: {
          loader: "babel-loader"
        }
      },
      {
        test: /\.scss$|\.css$/,
        use: [
          'style-loader',
          'css-loader',
          'sass-loader'
        ]
      }
    ],
  },
  plugins:[
    new VueLoaderPlugin()
  ]
};