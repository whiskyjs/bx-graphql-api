export class Singleton {
    protected static instances: SingletonInstanceStorage = {};

    // eslint-disable-next-line @typescript-eslint/no-unused-vars, @typescript-eslint/no-empty-function
    protected constructor() {
    }

    protected static getClassName(): string
    {
        return this.name;
    }

    public static getInstance(): InstanceType<any> {
        if (!this.instances[this.getClassName()]) {
            this.instances[this.getClassName()] = new this();
        }

        return this.instances[this.getClassName()];
    }
}
