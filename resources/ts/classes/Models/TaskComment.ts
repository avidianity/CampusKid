import { TaskCommentContract } from "~types/Models";
import Model from "./Model";
import { User, Task } from "@classes/Models";

export default class TaskComment extends Model implements TaskCommentContract {
    id?: number;
    body: string;
    user_id: number;
    user?: User;
    task_id: number;
    task?: Task;
    constructor(data: any) {
        super(data);
        this.id = data.id;
        this.body = data.body;
        this.user_id = data.user_id;
        this.task_id = data.task_id;
        if (data.user) {
            this.user = new User(data.user);
        }
        if (data.task) {
            this.task = new Task(data.task);
        }
    }
}
