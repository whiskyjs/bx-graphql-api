<template>
    <div class="vue-ts-component">
        <p @click="onClick">
            {{ title }}
        </p>
        <p>
            <button @click="state.increase()">
                MobX-Vue: {{ state.counter }}
            </button>
        </p>
    </div>
</template>

<script lang="ts">
    import Vue from "vue";
    import Component from "vue-class-component";
    import StateTs from "../models/StateTs";
    import {Observer} from "mobx-vue";

    @Observer
    @Component({})
    export default class DemoTs extends Vue {
        protected message = "Here's Johnny!";
        protected title = "Vue: компонент на классах (TS)";

        protected state = new StateTs();

        public onClick(): void {
            window.alert(this.message)
        }
    }
</script>
