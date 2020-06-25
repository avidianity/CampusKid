import { SubjectContract } from "~types/Models";
import Model from "./Model";
import { Classroom } from "@classes/Models";

export default class Subject extends Model implements SubjectContract {
    id?: number;
    code: string;
    name: string;
    description: string | null;
    units: number;
    classrooms?: Array<Classroom>;
    constructor(data: any) {
        super(data);
        this.id = data.id;
        this.code = data.code;
        this.name = data.name;
        this.description = data.description;
        this.units = data.units;
        if (data.classrooms) {
            const classrooms: Array<Classroom> = [];
            for (const classroom of data.classrooms) {
                classrooms.push(new Classroom(classroom));
            }
            this.classrooms = classrooms;
        }
    }
}
