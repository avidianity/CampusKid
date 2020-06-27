import {
    TimestampContract,
    FileContract,
    StudentContract,
    TaskContract
} from ".";

export default interface TaskSubmissionContract extends TimestampContract {
    id?: number;
    remarks: string;
    task_id: number;
    task?: TaskContract;
    student_id: number;
    student?: StudentContract;
    files?: Array<FileContract>;
}
