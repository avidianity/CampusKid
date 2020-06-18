import { DetailContract } from "~types/Models";
import Model from "./Model";

export default class Detail extends Model implements DetailContract {
    id: number;
    first_name: string;
    last_name: string;
    gender: string;
    birthday: Date;
    address: string;
    user_id: number;
    constructor(data: any) {
        super(data);
        this.id = data.id;
        this.first_name = data.first_name;
        this.last_name = data.last_name;
        this.gender = data.gender;
        this.birthday = new Date(data.birthday);
        this.address = data.address;
        this.user_id = data.user_id;
    }
}
