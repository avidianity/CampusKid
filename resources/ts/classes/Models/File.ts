import { FileContract } from "~types/Models";
import Model from "./Model";

export default class File extends Model implements FileContract {
    id?: number;
    name: string;
    type: string;
    url: string;
    constructor(data: any) {
        super(data);
        this.id = data.id;
        this.name = data.name;
        this.type = data.type;
        this.url = data.url;
    }
}
