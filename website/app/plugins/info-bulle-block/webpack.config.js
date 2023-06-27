/*
	The config of the plugin to use react/jsx
	Minimal config to work with jsx and webpack
 */
const path = require('path');

module.exports = {
    mode: 'development',
    /* The entry point of our jsx index file */
    entry: './blocks/info-bulle-block/index.jsx',

    /* Defines where the min file will be outputed and what file to generate */
    output : {
        path: path.resolve(__dirname, 'blocks/info-bulle-block'),
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
    },

}


