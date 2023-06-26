const path = require('path');

module.export = {
    entry: './blocks/info-bulle-block/index.jsx',
    output : {
        path: path.resolve(__dirname, 'block/info-bulle-block'),
        filename: 'index.js'
    },
    module: {
      rules: [
          {
              test: /.jsx?$/,
              loader: 'babel-loader',
              exclude: /node_modules/,
          }
      ]
    }
}