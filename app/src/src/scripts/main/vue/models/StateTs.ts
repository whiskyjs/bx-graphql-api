import {action, computed, observable} from "mobx";

export default class StateTs {
    @observable public counter = 1;

    @computed public get nextCounter(): number {
        return this.counter + 1;
    }

    @action.bound increase(): void {
        this.counter++;
    }
}
