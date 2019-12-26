const {resolve} = require("path");
const webpack = require("webpack");
const {CleanWebpackPlugin} = require("clean-webpack-plugin");
const CopyWebpackPlugin = require("copy-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const ExtraWatchWebpackPlugin = require("extra-watch-webpack-plugin");
const VueLoaderPlugin = require("vue-loader/lib/plugin");

const config = {
    context: resolve(__dirname, "src"),

    entry: {
        "graphiql": [
            "./graphiql.ts",
        ],
    },

    module: {
        rules: [
            {
                test: /\.(png|jpg)$/,
                use: "url-loader?limit=15000",
            },
            {
                test: /\.svg$/,
                loader: "url-loader?limit=65536&mimetype=image/svg+xml&name=fonts/[name].[ext]",
            },
            {
                test: /\.woff$/,
                loader: "url-loader?limit=65536&mimetype=application/font-woff&name=fonts/[name].[ext]",
            },
            {
                test: /\.woff2$/,
                loader: "url-loader?limit=65536&mimetype=application/font-woff2&name=fonts/[name].[ext]",
            },
            {
                test: /\.[ot]tf$/,
                loader: "url-loader?limit=65536&mimetype=application/octet-stream&name=fonts/[name].[ext]",
            },
            {
                test: /\.eot$/,
                loader: "url-loader?limit=65536&mimetype=application/vnd.ms-fontobject&name=fonts/[name].[ext]",
            },
            {
                test: /\.[tj]sx?$/,
                use: [
                    {
                        loader: "babel-loader",
                    }
                ],
                exclude: /node_modules/,
            },
            {
                test: /\.scss$/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                    },
                    {
                        loader: "css-loader",
                        options: {
                            url: false,
                        },
                    },
                    {
                        loader: "sass-loader",
                    },
                ],
            },
            {
                test: /\.less$/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                    },
                    {
                        loader: "css-loader",
                        options: {
                            url: false,
                        },
                    },
                    {
                        loader: "less-loader",
                    },
                ],
            },
            {
                test: /\.css$/,
                use: ["style-loader", "css-loader"],
            },
            {
                test: /\.vue$/,
                loader: "vue-loader"
            }
        ],
    },

    output: {
        filename: "js/[name].js",
        path: resolve(__dirname, "../dist"),
    },

    optimization: {
        runtimeChunk: "single",
        splitChunks: {
            cacheGroups: {
                vendor: {
                    test: /[\\/]node_modules[\\/]/,
                    name: "vendors",
                    enforce: true,
                    chunks: "all"
                }
            }
        }
    },

    plugins: [
        new CleanWebpackPlugin({
            root: resolve(__dirname, "."),
            verbose: true,
            dry: false,
            cleanStaleWebpackAssets: false,
        }),

        new CopyWebpackPlugin(
            [
                {
                    from: resolve("./src/assets"),
                    to: resolve("../dist/"),
                },
            ]
        ),

        new ExtraWatchWebpackPlugin({
            dirs: ["src/pages"],
        }),

        new MiniCssExtractPlugin({
            filename: "css/[name].css",
            chunkFilename: "css/[id].css",
        }),

        new webpack.ProvidePlugin({
            $: "jquery",
        }),

        new VueLoaderPlugin(),
    ],

    resolve: {
        modules: [
            "node_modules",
        ],

        alias: {
            "@graphiql": resolve(__dirname, "src/scripts/graphiql"),
            "@std": resolve(__dirname, "src/scripts/std"),
            "@styles": resolve(__dirname, "src/styles"),
        },

        extensions: [".mjs", ".js", ".jsx", ".ts", ".tsx", ".css", ".scss", ".less", ".vue"],
    },
};

module.exports = config;
