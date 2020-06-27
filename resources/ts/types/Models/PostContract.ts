import {
    TimestampContract,
    UserContract,
    ClassroomContract,
    PostCommentContract,
    FileContract
} from ".";

export default interface PostContract extends TimestampContract {
    id?: number;
    body: string;
    user_id: number;
    classroom_id: number;
    user?: UserContract;
    classroom?: ClassroomContract;
    comments?: Array<PostCommentContract>;
    files?: Array<FileContract>;
}
