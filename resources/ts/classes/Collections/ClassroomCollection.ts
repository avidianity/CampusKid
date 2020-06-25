import PaginatedCollection from "./PaginatedCollection";
import { PaginationContract } from "~types/Models";
import Classroom from "@models/Classroom";

export default class ClassroomCollection extends PaginatedCollection {
    data: Array<Classroom>;
    constructor(response: PaginationContract) {
        super(response);
        this.data = [];
        this.fillModels(response.data, "Classroom");
    }
}
