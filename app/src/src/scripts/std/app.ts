import URI from "urijs";

import {Singleton} from "@std/base/Singleton";
import {isJsonMap} from "@std/guards";

export class App extends Singleton {
    protected config: JsonMap = {};

    public constructor() {
        super();
    }

    public loadConfig(config: JsonMap): void {
        this.config = config;
    }

    public getOption(optionName: string, defaultValue?: any): JsonValue {
        const optionPath = optionName.split(".");

        let option: JsonValue = this.config;

        for (const key of optionPath) {
            if (isJsonMap(option)) {
                option = option[key];
            } else if (defaultValue) {
                return defaultValue;
            } else {
                throw new Error(`Опция ${optionName} не найдена.`);
            }
        }

        return option;
    }

    /**
     * @param {string} url
     * @param {string} lang
     * @return {string}
     */
    public getUrl(url: string, lang: string = BX.message("LANGUAGE_ID")): string {
        const uri = URI(url);

        const segments = uri.segment();
        const languages = this.getOption("main.loc.languages");

        if (!languages || (typeof languages !== "object")) {
            throw new Error("Не определены поддерживаемые сайтом языки.")
        }

        const languageCodes = Object.keys(languages);

        if (segments && ~languageCodes.indexOf(segments[0])) {
            segments.shift();
        }

        if (lang !== this.getOption("main.loc.default_language")) {
            segments.unshift(lang);
        }

        uri.segment(segments);

        return uri.toString();
    }
}
