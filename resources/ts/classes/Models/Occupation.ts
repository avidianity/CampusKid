import { OccupationContract } from "~types/Models";
import Model from "./Model";
import { Faculty, Administrator } from "@classes/Models";

export default class Occupation extends Model implements OccupationContract {
    id?: number;
    name: string;
    administrators?: Array<Administrator>;
    faculties?: Array<Faculty>;
    constructor(data: any) {
        super(data);
        this.id = data.id;
        this.name = data.name;
        if (data.administrators) {
            this.administrators = [];
            for (const administrator of data.administrators) {
                this.administrators.push(new Administrator(administrator));
            }
        }
        if (data.faculties) {
            this.faculties = [];
            for (const faculty of data.faculties) {
                this.faculties.push(new Faculty(faculty));
            }
        }
    }
}
