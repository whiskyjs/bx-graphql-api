import Vue from "vue/dist/vue.js";
import React from "react";
import ReactDOM from "react-dom";

import {App as StdApp} from "@std/app";

import VueJsApp from "@main/vue/AppJs";
import VueTsApp from "@main/vue/AppTs";

import {StatelessApp} from "@main/react/StatelessApp";
import {StatefulApp} from "@main/react/StatefulApp";
import {MobXApp} from "@main/react/MobXApp";

export class App extends StdApp {
    constructor() {
        super();

        /* eslint-disable no-new */
        new Vue({
            el: "#vue-js-app",
            // eslint-disable-next-line
            render: h => h(VueJsApp)
        });

        /* eslint-disable no-new */
        new Vue({
            el: "#vue-ts-app",
            // eslint-disable-next-line
            render: h => h(VueTsApp)
        });

        ReactDOM.render(
            React.createElement(StatelessApp, {}, null),
            document.getElementById("react-stateless-app")
        );

        ReactDOM.render(
            React.createElement(StatefulApp, {}, null),
            document.getElementById("react-stateful-app")
        );

        ReactDOM.render(
            React.createElement(MobXApp, {}, null),
            document.getElementById("react-mobx-app")
        );
    }

    loadConfig(config) {
        super.loadConfig(config);
    }
}
