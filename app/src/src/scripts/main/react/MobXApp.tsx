import * as React from "react";
import {Provider} from "mobx-react"

import {MobXStore} from "./models/MobXStore";
import {MobXComponent} from "./components/MobXComponent";

export class MobXApp extends React.PureComponent<{}, {}> {
    public store = new MobXStore();

    public render(): JSX.Element {
        return (
            <Provider store={this.store}>
                <div className="react-mobx-app">
                    <MobXComponent/>
                </div>
            </Provider>
        );
    }
}
