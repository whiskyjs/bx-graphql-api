import * as React from "react";
import {observer, inject} from "mobx-react"

import {MobXStore} from "../models/MobXStore";

interface MobXComponentProps {
    store?: MobXStore;
}

@inject("store")
@observer
export class MobXComponent extends React.PureComponent<MobXComponentProps, {}> {
    public store = new MobXStore();

    public render(): JSX.Element {
        const {store} = this.props;

        return (
            <p>
                <button onClick={store!.increase}>
                    React-MobX (TSX): {store!.counter}
                </button>
            </p>
        );
    }
}
