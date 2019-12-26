module.exports = {
    "presets": [
        ["@babel/env", {
            useBuiltIns: "usage",
            corejs: 3,
        }],
        ["@babel/react"],
        ["babel-preset-typescript-vue"]
    ],
    "plugins": [
        ["@babel/plugin-proposal-decorators", {"legacy": true}],
        ["@babel/plugin-proposal-optional-chaining"],
        ["@babel/proposal-class-properties", {"loose": true}],
        "@babel/proposal-object-rest-spread"
    ]
};
