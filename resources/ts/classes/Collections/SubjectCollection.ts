import PaginatedCollection from "./PaginatedCollection";
import { PaginationContract } from "~types/Models";
import Subject from "@models/Subject";

export default class SubjectCollection extends PaginatedCollection {
    data: Array<Subject>;
    constructor(response: PaginationContract) {
        super(response);
        this.data = [];
        this.fillModels(response.data, "Subject");
    }
}
