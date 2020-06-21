import PaginatedCollection from "./PaginatedCollection";
import { PaginationContract } from "~types/Models";
import Administrator from "@models/Administrator";

export default class AdministratorCollection extends PaginatedCollection {
    data: Array<Administrator>;
    constructor(response: PaginationContract) {
        super(response);
        this.data = [];
        this.fillModels(response.data, "Administrator");
    }
}
