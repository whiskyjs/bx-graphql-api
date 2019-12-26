import React from "react";
import ReactDOM from "react-dom";

// eslint-disable-next-line @typescript-eslint/ban-ts-ignore
// @ts-ignore
import GraphiQL from "graphiql";

import {App as StdApp} from "@std/app";
import {isJsonMap} from "@std/guards";

export class App extends StdApp {
    constructor() {
        super();

        this.setEventHandlers();
    }

    setEventHandlers(): void {
        document.addEventListener("DOMContentLoaded", () => {
            if (isJsonMap(window.config) && (Object.keys(this.config).length === 0)) {
                this.loadConfig(window.config);
            }

            const graphQLFetcher = (payload: any): Promise<Response>|boolean => {
                if (isJsonMap(this.config) && isJsonMap(this.config.graphql)) {
                    return fetch(String(this.config.graphql.endpoint), {
                        method: "post",
                        headers: {"Content-Type": "application/json"},
                        body: JSON.stringify(payload),
                    }).then(response => response.json());
                } else {
                    return false;
                }
            };

            ReactDOM.render(
                <GraphiQL fetcher={graphQLFetcher}/>,
                document.getElementById("graphiql-anchor")
            );
        });
    }
}
