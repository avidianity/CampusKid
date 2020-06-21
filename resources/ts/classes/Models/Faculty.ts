import { FacultyContract } from "~types/Models";
import Model from "./Model";
import Occupation from "./Occupation";
import Department from "./Department";
import User from "./User";

export default class Faculty extends Model implements FacultyContract {
    id?: number;
    occupation_id: number;
    occupation?: Occupation;
    department_id: number;
    department?: Department;
    user_id: number;
    user?: User;
    constructor(data: any) {
        super(data);
        this.id = data.id;
        this.occupation_id = data.occupation_id;
        this.department_id = data.department_id;
        this.user_id = data.user_id;
        if (data.occupation) {
            this.occupation = new Occupation(data.occupation);
        }
        if (data.department) {
            this.department = new Department(data.department);
        }
        if (data.user) {
            this.user = new User(data.user);
        }
    }
}
