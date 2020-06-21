import PaginatedCollection from "./PaginatedCollection";
import { PaginationContract } from "~types/Models";
import User from "@models/User";

export default class UserCollection extends PaginatedCollection {
    data: Array<User>;
    constructor(response: PaginationContract) {
        super(response);
        this.data = [];
        this.fillModels(response.data, "User");
    }
}
