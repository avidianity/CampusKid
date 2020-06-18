import { PaginationContract } from "~types/Models";

import Occupation from "@classes/Models/Occupation";
import Department from "@classes/Models/Department";

const ClassModel = {
    ["Department" as string]: Department,
    ["Occupation" as string]: Occupation
};

export abstract class PaginatedCollection implements PaginationContract {
    current_page: number;
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    next_page_url: string;
    path: string;
    per_page: number;
    prev_page_url: string;
    to: number;
    total: number;
    data: Array<any>;
    constructor(response: PaginationContract) {
        this.current_page = response.current_page;
        this.first_page_url = response.first_page_url;
        this.from = response.from;
        this.last_page = response.last_page;
        this.last_page_url = response.last_page_url;
        this.next_page_url = response.next_page_url;
        this.path = response.path;
        this.per_page = response.per_page;
        this.prev_page_url = response.prev_page_url;
        this.to = response.to;
        this.total = response.total;
        this.data = [];
    }
    fillModels(models: Array<object>, classname: string) {
        for (const data of models) {
            this.data.push(new ClassModel[classname](data));
        }
    }
}
