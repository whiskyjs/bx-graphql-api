const merge = require("webpack-merge");
const OptimizeCssAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const TerserPlugin = require("terser-webpack-plugin");
const base = require("./webpack.base");

module.exports = merge(base, {
    devtool: false,

    // НЕ выставлять в "production", т.к. Webpack будет переименовывать css-чанки (конфликт с MiniCssExtractPlugin?)
    // TODO: Разобраться, в чём дело
    mode: "development",

    optimization: {
        minimize: true,
        minimizer: [
            new TerserPlugin({
                extractComments: false,
            }),
            new OptimizeCssAssetsPlugin({})
        ],
    },
});
