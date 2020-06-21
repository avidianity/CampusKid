import { AdministratorContract } from "~types/Models";
import Model from "./Model";
import Occupation from "./Occupation";
import User from "./User";

export default class Administrator extends Model
    implements AdministratorContract {
    id?: number;
    occupation_id: number;
    occupation?: Occupation;
    user_id: number;
    user?: User;
    constructor(data: any) {
        super(data);
        this.id = data.id;
        this.occupation_id = data.occupation_id;
        this.user_id = data.user_id;
        if (data.occupation) {
            this.occupation = new Occupation(data.occupation);
        }
        if (data.user) {
            this.user = new User(data.user);
        }
    }
}
