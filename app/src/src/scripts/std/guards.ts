export function isJsonMap(object: any): object is JsonMap {
    return object && (typeof object === "object") && !Array.isArray(object);
}
