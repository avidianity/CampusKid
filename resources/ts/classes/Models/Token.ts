import { TokenContract } from "~types/Models";
import Model from "./Model";
import { Login } from "@classes/Models";

export default class Token extends Model implements TokenContract {
    id?: number;
    tokenable_type: string;
    tokenable_id: number;
    name: string;
    token?: string;
    abilities: string | Array<string>;
    last_used_at: Date | null;
    login?: Login;
    constructor(data: any) {
        super(data);
        this.id = data.id;
        this.tokenable_type = data.tokenable_type;
        this.tokenable_id = data.tokenable_id;
        this.name = data.name;
        this.abilities = data.abilities;
        this.last_used_at = data.last_used_at
            ? new Date(data.last_used_at)
            : null;
        if (data.login) {
            this.login = new Login(data.login);
        }
    }
}
