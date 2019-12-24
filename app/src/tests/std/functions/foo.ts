import {foo} from "@std/functions";

test("Jest is set up correctly", () => {
    expect(foo()).toBe(foo.name);
});
