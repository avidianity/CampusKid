import { PaginatedCollection } from "./PaginatedCollection";
import { PaginationContract } from "~types/Models";
import Occupation from "@models/Occupation";

export class OccupationCollection extends PaginatedCollection {
    data: Array<Occupation>;
    constructor(response: PaginationContract) {
        super(response);
        this.data = [];
        this.fillModels(response.data, "Occupation");
    }
}
