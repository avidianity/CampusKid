import { LoginContract } from "~types/Models";
import { User, Token } from "@classes/Models";

export default class Login implements LoginContract {
    id?: number;
    user_agent: string;
    ip_address: string;
    user_id: number;
    token_id: number;
    date: Date;
    user?: User;
    token?: Token;
    [key: string]: any;
    constructor(data: any) {
        this.id = data.id;
        this.user_agent = data.user_agent;
        this.ip_address = data.ip_address;
        this.user_id = data.user_id;
        this.token_id = data.token_id;
        this.date = new Date(data.date);
        if (data.user) {
            this.user = new User(data.user);
        }
        if (data.token) {
            this.token = new Token(data.token);
        }
    }
    fill(data: any): this {
        for (const key in data) {
            this[key] = data[key];
        }
        return this;
    }
    save(url: string, headers: Object = {}) {
        return this.id
            ? Axios.post(url, this, headers)
            : Axios.put(url, this, headers);
    }
}
