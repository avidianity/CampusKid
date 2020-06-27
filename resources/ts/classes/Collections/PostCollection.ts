import PaginatedCollection from "./PaginatedCollection";
import { PaginationContract } from "~types/Models";
import Post from "@models/Post";

export default class PostCollection extends PaginatedCollection {
    data: Array<Post>;
    constructor(response: PaginationContract) {
        super(response);
        this.data = [];
        this.fillModels(response.data, "Post");
    }
}
