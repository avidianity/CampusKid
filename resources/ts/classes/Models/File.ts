import { FileContract } from "~types/Models";
import Model from "./Model";

export default class File extends Model implements FileContract {
    id?: number;
    name: string;
    type: string;
    url: string;
    real_name: string;
    constructor(data: any) {
        super(data);
        this.id = data.id;
        this.name = data.name;
        this.type = data.type;
        this.url = data.url;
        this.real_name = data.real_name;
    }
    downloadUrl() {
        return `${window.location.origin}/api/download/${this.id as number}`;
    }
}
