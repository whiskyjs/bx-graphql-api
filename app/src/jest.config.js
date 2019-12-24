module.exports = {
    preset: "ts-jest",
    testEnvironment: "node",
    testMatch: [ "**/tests/**/*.[jt]s?(x)", "**/?(*.)+(spec|test).[jt]s?(x)" ],
    moduleNameMapper: {
        "^@std/(.*)$": "<rootDir>/src/scripts/std/$1",
        "^@main/(.*)$": "<rootDir>/src/scripts/main/$1",
    },
};
