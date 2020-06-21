import PaginatedCollection from "./PaginatedCollection";
import { PaginationContract } from "~types/Models";
import Department from "@models/Department";

export default class DepartmentCollection extends PaginatedCollection {
    data: Array<Department>;
    constructor(response: PaginationContract) {
        super(response);
        this.data = [];
        this.fillModels(response.data, "Department");
    }
}
