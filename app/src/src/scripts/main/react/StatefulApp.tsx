import * as React from "react";

interface StatefulAppProps {
    count: number;
}

interface StatefulAppState {
    counter: number;
}

export class StatefulApp extends React.PureComponent<StatefulAppProps, StatefulAppState> {
    public static defaultProps: Partial<StatefulAppProps> = {
        count: 1,
    };

    public state: StatefulAppState = {
        counter: 1,
    };

    public increase = (): void => this.setState({
        ...this.state,

        counter: this.state.counter + 1,
    });

    public render(): JSX.Element {
        return (
            <div className="react-stateful-app">
                <p>
                    React: компонент на классах (TSX)
                </p>
                <p>
                    <button onClick={this.increase}>
                        State: {this.state.counter}
                    </button>
                </p>
            </div>
        );
    }
}
