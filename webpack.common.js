// Base
const path = require('path');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');

// Webpack Plugins
const ExtractTextPlugin = require('extract-text-webpack-plugin');

const extractCSS = new ExtractTextPlugin({filename: 'client/dist/styles/hail-carousel.bundle.css'});

module.exports = {
    entry: [
        './client/src/js/index.js',
    ],
    output: {
        filename: 'client/dist/js/hail-carousel.bundle.js',
        path: path.resolve(__dirname, './')
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: [
                    {
                        loader: 'babel-loader',
                        options: {
                            presets: [
                                "env",
                                "stage-2"
                            ]
                        }
                    }
                ]
            },
            {
                test: /\.scss$/,
                exclude: /node_modules/,
                use: extractCSS.extract({
                    use: [
                        {
                            loader: 'css-loader',
                            options: {
                                sourceMap: true
                            }
                        },
                        {
                            loader: 'postcss-loader',
                            options: {
                                sourceMap: true,
                                plugins: [
                                    autoprefixer
                                ]
                            }
                        },
                        {
                            loader: 'sass-loader',
                            options: {
                                sourceMap: true
                            }
                        }
                    ]
                })
            }, {
                test: /\.css$/,
                exclude: /node_modules/,
                use: extractCSS.extract({
                    use: [
                        {
                            loader: 'css-loader',
                            options: {
                                sourceMap: true
                            }
                        },
                        {
                            loader: 'postcss-loader',
                            options: {
                                sourceMap: true,
                                plugins: [
                                    autoprefixer
                                ]
                            }
                        }
                    ]
                })
            }, {
                test: /\.(png|ico|svg|jpg|gif)$/,
                exclude: /node_modules/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[name].[ext]',
                            outputPath: './client/dist/',
                            publicPath: "../images",
                            useRelativePath: true
                        }
                    }
                ]
            }, {
                test: /\.(ttf|eot|woff|woff2)$/,
                exclude: /node_modules/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[name].[ext]',
                            outputPath: './client/dist/',
                            publicPath: "../fonts",
                            useRelativePath: true
                        }
                    }
                ]
            }
        ]
    },
    plugins: [
        extractCSS
    ]
};
