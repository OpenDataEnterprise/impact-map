const glob = require("glob");
const path = require('path');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const entryPlus = require('webpack-entry-plus');

function defaultFilename (filename) {
  return filename.split('/').pop();
}

// Define entry points here (to be processed through webpack-entry-plus).
const entryFiles = [
  {
    entryFiles: './scripts/index.js',
    outputName: 'index.js',
  },
  {
    entryFiles: './scripts/useCases.js',
    outputName: 'useCases.js',
  },
  {
    entryFiles: glob.sync('./scripts/regions/*.js'),
    outputName: defaultFilename,
  },
  {
    entryFiles: glob.sync('./scripts/sectors/*.js'),
    outputName: defaultFilename,
  },
];

module.exports = () => {
  return {
    entry: entryPlus(entryFiles),
    output: {
      filename: '[name]',
      path: path.resolve(__dirname, './dist/js')
    },
    module: {
      rules: [
        {
          test: /\.js$/,
          use: {
            loader: 'babel-loader'
          },
          exclude: /(node_modules)/
        }
      ]
    },
    plugins: [
      new UglifyJsPlugin({ test: /\.js$/ }),
    ],
    resolve: {
      modules: [
        path.resolve('./scripts'),
        path.resolve('./node_modules')
      ]
    }
  };
};
