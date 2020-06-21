import { DepartmentContract } from "~types/Models";
import Model from "./Model";

export default class Department extends Model implements DepartmentContract {
    id?: number;
    name: string;
    abbreviation: string;
    constructor(data: any) {
        super(data);
        this.id = data.id;
        this.name = data.name;
        this.abbreviation = data.abbreviation;
    }
}
