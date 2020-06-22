import PaginatedCollection from "./PaginatedCollection";
import { PaginationContract } from "~types/Models";
import Student from "@models/Student";

export default class StudentCollection extends PaginatedCollection {
    data: Array<Student>;
    constructor(response: PaginationContract) {
        super(response);
        this.data = [];
        this.fillModels(response.data, "Student");
    }
}
