import {
    TimestampContract,
    ClassroomContract,
    FileContract,
    TaskCommentContract,
    TaskSubmissionContract
} from ".";

export default interface TaskContract extends TimestampContract {
    id?: number;
    name: string;
    description: string;
    deadline: Date;
    done: boolean;
    classroom_id: number;
    classroom?: ClassroomContract;
    files?: Array<FileContract>;
    comments?: Array<TaskCommentContract>;
    submissions?: Array<TaskSubmissionContract>;
}
