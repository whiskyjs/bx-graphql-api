module.exports = {
    "presets": [
        ["@babel/env"],
        ["@babel/react"],

        ["babel-preset-typescript-vue"]
    ],
    "plugins": [
        ["@babel/plugin-proposal-decorators", {"legacy": true}],
        ["@babel/proposal-class-properties", {"loose": true}],
        "@babel/proposal-object-rest-spread"
    ]
};
