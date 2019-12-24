<template>
    <div class="vue-js-app">
        <p>{{ msg }}</p>
    </div>
</template>

<script lang="js">
    export default {
        name: "VueJsApp",
        data: () => ({
            msg: "Vue: однофайловое приложение (JS)"
        }),
    };
</script>

<style lang="scss">
    .vue-js-app {
        p {
            font-size: 14px;
            text-align: center;
            color: lightseagreen;
        }
    }
</style>
