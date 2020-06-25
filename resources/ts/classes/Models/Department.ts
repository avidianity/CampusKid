import { DepartmentContract } from "~types/Models";
import Model from "./Model";
import { Faculty, Student } from "@classes/Models";

export default class Department extends Model implements DepartmentContract {
    id?: number;
    name: string;
    abbreviation: string;
    students?: Array<Student>;
    faculties?: Array<Faculty>;
    constructor(data: any) {
        super(data);
        this.id = data.id;
        this.name = data.name;
        this.abbreviation = data.abbreviation;
        if (data.students) {
            this.students = [];
            const students: Array<Student> = [];
            for (const student of data.students) {
                this.students.push(new Student(student));
            }
        }
        if (data.faculties) {
            this.faculties = [];
            const faculties: Array<Faculty> = [];
            for (const faculty of data.faculties) {
                this.faculties.push(new Faculty(faculty));
            }
        }
    }
}
