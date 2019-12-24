interface SingletonInstanceStorage {
    [klass: string]: InstanceType<any>;
}

type JsonValue = boolean | number | string | null | JsonArray | JsonMap;

interface JsonMap {
    [key: string]: JsonValue;
}

// eslint-disable-next-line @typescript-eslint/no-empty-interface
interface JsonArray extends Array<JsonValue> {
}
