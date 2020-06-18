export default class FormValidation {
    private rules: string[];
    private names: object;
    private ruleset: object;
    private errors: string[];
    private validators: object;
    constructor(rules: string[], names: object) {
        this.rules = rules;
        this.names = names;
        this.errors = [];
        this.ruleset = {
            required: "is required."
        };
        this.validators = {
            email: /[\w-]+@([\w-]+\.)+[\w-]+/
        };
    }
    validate(data: any): boolean {
        if ("required" in this.rules) {
            for (const key in data) {
                if (data[key].length === 0) {
                    this.errors.push(this.createError(key, "required"));
                }
            }
        }
        return this.errors.length === 0;
    }
    getErrors(): string[] {
        return this.errors;
    }
    createError(key: string, rule: string): string {
        const ruleset = this.ruleset as any;
        const names = this.names as any;
        return `${names[key]} ${ruleset[rule]}`;
    }
}

export class ValidationMessage {
    private validation_message_class: object;
    private validation_messages: string[];
    private set: boolean;
    private hasDefault: boolean;
    constructor(default_validation_message: string = "") {
        this.validation_message_class = {};
        this.validation_messages = [];
        this.hasDefault = default_validation_message.length > 0;
        if (this.hasDefault) {
            this.validation_messages.push(default_validation_message);
        }
        this.set = false;
    }
    has(): boolean {
        return this.set;
    }
    clear(): this {
        this.validation_message_class = {};
        this.validation_messages = [""];
        this.set = false;
        return this;
    }
    timeout(
        validation_message: string,
        type: string = "info",
        duration: number = 5000
    ): this {
        this.validation_message_class = {
            [`alert-${type}`]: true,
            "form-alert": true
        };
        this.validation_messages.push(validation_message);
        this.set = true;
        if (this.hasDefault) {
            this.validation_messages.splice(0, 1);
            this.hasDefault = false;
        }
        setTimeout(() => {
            this.clear();
        }, duration);
        return this;
    }
    normal(validation_message: string): this {
        this.validation_message_class = {};
        this.validation_messages.push(validation_message);
        this.set = true;
        if (this.hasDefault) {
            this.validation_messages.splice(0, 1);
            this.hasDefault = false;
        }
        return this;
    }
    success(validation_message: string): this {
        this.validation_message_class = {
            "alert-success": true,
            "form-alert": true
        };
        this.validation_messages.push(validation_message);
        this.set = true;
        if (this.hasDefault) {
            this.validation_messages.splice(0, 1);
            this.hasDefault = false;
        }
        return this;
    }
    info(validation_message: string): this {
        this.validation_message_class = {
            "alert-info": true,
            "form-alert": true
        };
        this.validation_messages.push(validation_message);
        this.set = true;
        if (this.hasDefault) {
            this.validation_messages.splice(0, 1);
            this.hasDefault = false;
        }
        return this;
    }
    warning(validation_message: string): this {
        this.validation_message_class = {
            "alert-warning": true,
            "text-white": true,
            "form-alert": true
        };
        this.validation_messages.push(validation_message);
        this.set = true;
        if (this.hasDefault) {
            this.validation_messages.splice(0, 1);
            this.hasDefault = false;
        }
        return this;
    }
    danger(validation_message: string): this {
        this.validation_message_class = {
            "alert-danger": true,
            "form-alert": true
        };
        this.validation_messages.push(validation_message);
        this.set = true;
        if (this.hasDefault) {
            this.validation_messages.splice(0, 1);
            this.hasDefault = false;
        }
        return this;
    }
    get class(): object {
        return this.validation_message_class;
    }
    get messages(): string[] {
        return this.validation_messages;
    }
}
