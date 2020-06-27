import { TimestampContract, UserContract, TaskContract } from "./index";

export default interface TaskCommentContract extends TimestampContract {
    id?: number;
    body: string;
    user_id: number;
    user?: UserContract;
    task_id: number;
    task?: TaskContract;
}
