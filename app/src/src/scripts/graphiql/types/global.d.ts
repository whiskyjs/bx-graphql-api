import {App} from "@graphiql/app";

declare global {
    interface Window {
        App: App;
        config: JsonMap;
    }
}
