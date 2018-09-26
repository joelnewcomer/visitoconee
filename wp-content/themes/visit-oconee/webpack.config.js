var webpack = require('webpack');
var path = require('path');
var glob = require('glob');
var ExtractTextPlugin = require('extract-text-webpack-plugin');
var CleanWebpackPlugin = require('clean-webpack-plugin');
var BrowserSyncPlugin = require('browser-sync-webpack-plugin');


var inProduction = (process.env.NODE_ENV === 'production');
// Replace URL of website.
var BaseURL = "http://drumstarter.local/";

module.exports = {
    entry: {

        footer_scripts: [
            './assets/javascript/footer.js'
        ],
        foundation: [
            './assets/scss/foundation.scss'
        ]
    },
    output: {
        path: path.resolve(__dirname + "/assets"),
        filename: './javascript/dist/[name].js'
    },
    devtool: "source-map",
    externals: {
        jquery: 'jQuery'
    },
    module: {
        rules: [
            {
                test: /\.html$/,
                loader: 'raw-loader',
                exclude: /node_modules/
            },
            {
                test: /\.s[ac]ss$/,
                exclude: /node_modules/,
                use: ExtractTextPlugin.extract( {
                    use: [{
                        loader: "css-loader", options: {
                            sourceMap: true
                        }
                    }, {
                        loader: "sass-loader", options: {
                            sourceMap: true
                        }
                    }]
                } )
            },
            {test: /\.woff($|\?)|\.woff2($|\?)|\.ttf($|\?)|\.eot($|\?)|\.svg($|\?)/, loader: 'url-loader'},
            {
                test: /\.(png|jpe?g|gif)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            // name: '/images/[name].[hash].[ext]'
                            name: '../../images/[name].[ext]'
                        }
                    }
                ]
            },
            // {
            //     test: /\.js$/,
            //     exclude: /node_modules/,
            //     loader: "babel-loader"
            // }
        ]
    },
    plugins: [
        new ExtractTextPlugin('./stylesheets/dist/foundation.css'),

        new webpack.LoaderOptionsPlugin({
            minimize: inProduction
        }),
        new CleanWebpackPlugin(['assets/javascript/dist'], {
            root: __dirname,
            verbose: true,
            dry: false
        }),
        new CleanWebpackPlugin(['assets/stylesheets/dist'], {
            root: __dirname,
            verbose: true,
            dry: false
        }),
        new webpack.ProvidePlugin({
            'window.jQuery': 'jquery',
            'window.$': 'jquery',
        }),
        new BrowserSyncPlugin({
        // BrowserSync options

            // browse to http://localhost:3000/ during development
            host: 'localhost',
            port: 3000,
            // proxy the Webpack Dev Server endpoint
            // (which should be serving on http://localhost:3100/)
            // through BrowserSync
            proxy: BaseURL,
            files: [
                {
                    match: [
                        '**/*.php'
                    ],
                    fn: function(event, file) {
                        if (event === "change") {
                            const bs = require('browser-sync').get('bs-webpack-plugin');
                            bs.reload();
                        }
                    }
                }
            ]

        })
    ]

};

if (inProduction) {
    module.exports.plugins.push(
        new webpack.optimize.UglifyJsPlugin('')
    );
}