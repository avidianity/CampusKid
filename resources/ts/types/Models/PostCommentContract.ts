import {
    TimestampContract,
    UserContract,
    FileContract,
    PostContract
} from "./index";

export default interface PostCommentContract extends TimestampContract {
    id?: number;
    body: string;
    post_id: number;
    user_id: number;
    post?: PostContract;
    user?: UserContract;
    files?: Array<FileContract>;
}
