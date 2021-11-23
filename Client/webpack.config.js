const path = require('path');
const extensions = ['w*', '.wasm', '.mjs', '.js', '.jsx', '.json', '.vue'];
const { VueLoaderPlugin } = require('vue-loader');

module.exports = {
  mode: 'development',
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
        // test: new RegExp(extensions.reduce((f,s)=>f+"|"+s+"$","w*$")),
        test:/\.vue$/,
        loader: 'vue-loader'
      }
    ],
  },
  plugins:[
    new VueLoaderPlugin()
  ]
};