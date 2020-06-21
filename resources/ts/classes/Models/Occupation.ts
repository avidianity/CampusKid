import { OccupationContract } from "~types/Models";
import Model from "./Model";

export default class Occupation extends Model implements OccupationContract {
    id?: number;
    name: string;
    constructor(data: any) {
        super(data);
        this.id = data.id;
        this.name = data.name;
    }
}
