<template>
    <div class="vue-ts-app">
        <DemoTs/>
    </div>
</template>

<script lang="js">
    import DemoTs from "./components/Demo.ts";

    export default {
        name: "VueTsApp",
        components: {DemoTs},
    }
</script>

<style lang="scss">
    .vue-ts-app {
        .vue-ts-component p {
            font-size: 14px;
            text-align: center;
            color: darkblue;
            cursor: pointer;
        }

        button {
            display: block;
            margin: 0 auto;
        }
    }
</style>
