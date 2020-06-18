export default abstract class Model {
    created_at: Date;
    updated_at: Date;
    [key: string]: any;
    constructor(response: any) {
        this.created_at = new Date(response.created_at);
        this.updated_at = new Date(response.updated_at);
    }
    fill(data: any): this {
        const non = ["created_at", "updated_at"];
        for (const key in data) {
            if (key in this && !(key in non)) {
                this[key] = data[key];
            }
        }
        return this;
    }
    save() {
        console.log(this.constructor.name);
    }
}
