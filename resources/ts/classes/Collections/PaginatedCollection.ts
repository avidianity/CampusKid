import { PaginationContract } from "~types/Models";

import * as Models from "@classes/Models";

const ClassModel = {
    ["Administrator" as string]: Models.Administrator,
    ["Classroom" as string]: Models.Classroom,
    ["Department" as string]: Models.Department,
    ["Detail" as string]: Models.Detail,
    ["Faculty" as string]: Models.Faculty,
    ["File" as string]: Models.File,
    ["Occupation" as string]: Models.Occupation,
    ["Post" as string]: Models.Post,
    ["PostComment" as string]: Models.PostComment,
    ["Student" as string]: Models.Student,
    ["Subject" as string]: Models.Subject,
    ["User" as string]: Models.User
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
        if (!(classname in ClassModel)) {
            console.error(
                `${classname} is not registered in ClassModel.`,
                ClassModel
            );
            throw new Error(`${classname} is not registered in ClassModel.`);
        }
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
