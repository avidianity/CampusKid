import { StudentContract } from "~types/Models";
import Model from "./Model";
import { Department, User, Classroom } from "@classes/Models";

export default class Student extends Model implements StudentContract {
    id?: number;
    department_id: number;
    department?: Department;
    user_id: number;
    user?: User;
    classrooms?: Array<Classroom>;
    constructor(data: any) {
        super(data);
        this.id = data.id;
        this.department_id = data.department_id;
        this.user_id = data.user_id;
        if (data.department) {
            this.department = new Department(data.department);
        }
        if (data.user) {
            this.user = new User(data.user);
        }
        if (data.classrooms) {
            const classrooms: Array<Classroom> = [];
            for (const classroom of data.classrooms) {
                classrooms.push(new Classroom(classroom));
            }
            this.classrooms = classrooms;
        }
    }
}
