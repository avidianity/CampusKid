import { StudentContract } from "~types/Models";
import Model from "./Model";
import Department from "./Department";

export default class Student extends Model implements StudentContract {
    id?: number;
    department_id: number;
    department?: Department;
    user_id: number;
    constructor(data: any) {
        super(data);
        this.id = data.id;
        this.department_id = data.department_id;
        this.user_id = data.user_id;
        if (data.department) {
            this.department = new Department(data.department);
        }
    }
}
