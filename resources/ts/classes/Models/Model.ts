import { ModelContract } from "~types/Models";

export default abstract class Model implements ModelContract {
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
    save(url: string, headers: Object = {}) {
        return this.id
            ? Axios.post(url, this, headers)
            : Axios.put(url, this, headers);
    }
}
