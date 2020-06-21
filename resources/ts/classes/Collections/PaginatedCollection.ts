import { PaginationContract } from "~types/Models";

import Administrator from "@classes/Models/Administrator";
import Department from "@classes/Models/Department";
import Detail from "@classes/Models/Detail";
import Faculty from "@classes/Models/Faculty";
import File from "@classes/Models/File";
import Occupation from "@classes/Models/Occupation";
import Student from "@classes/Models/Student";
import User from "@classes/Models/User";

const ClassModel = {
    ["Administrator" as string]: Administrator,
    ["Department" as string]: Department,
    ["Detail" as string]: Detail,
    ["Faculty" as string]: Faculty,
    ["File" as string]: File,
    ["Occupation" as string]: Occupation,
    ["Student" as string]: Student,
    ["User" as string]: User
};

export default abstract class PaginatedCollection
    implements PaginationContract {
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
    fillModels(models: Array<any>, classname: string) {
        for (const data of models) {
            this.data.push(new ClassModel[classname](data));
        }
    }
    hasPreviousPage(): boolean {
        return this.prev_page_url !== null;
    }
    hasNextPage(): boolean {
        return this.next_page_url !== null;
    }
}
