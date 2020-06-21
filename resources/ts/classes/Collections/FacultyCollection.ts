import PaginatedCollection from "./PaginatedCollection";
import { PaginationContract } from "~types/Models";
import Faculty from "@models/Faculty";

export default class FacultyCollection extends PaginatedCollection {
    data: Array<Faculty>;
    constructor(response: PaginationContract) {
        super(response);
        this.data = [];
        this.fillModels(response.data, "Faculty");
    }
}
