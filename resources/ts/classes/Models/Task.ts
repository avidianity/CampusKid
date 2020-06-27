import { TaskContract } from "~types/Models";
import Model from "./Model";
import { Classroom, File, TaskComment, TaskSubmission } from "@classes/Models";

export default class Task extends Model implements TaskContract {
    id?: number;
    name: string;
    description: string;
    deadline: Date;
    done: boolean;
    classroom_id: number;
    classroom?: Classroom;
    files?: Array<File>;
    comments?: Array<TaskComment>;
    submissions?: Array<TaskSubmission>;
    constructor(data: any) {
        super(data);
        this.id = data.id;
        this.name = data.name;
        this.description = data.description;
        this.deadline = new Date(data.deadline);
        this.done = data.done;
        this.classroom_id = data.classroom_id;
        if (data.classroom) {
            this.classroom = new Classroom(data.classroom);
        }
        if (data.files) {
            const files: Array<File> = [];
            for (const file of data.files) {
                files.push(new File(file));
            }
            this.files = files;
        }
        if (data.comments) {
            const comments: Array<TaskComment> = [];
            for (const comment of data.comments) {
                comments.push(new TaskComment(comment));
            }
            this.comments = comments;
        }
        if (data.submissions) {
            const submissions: Array<TaskSubmission> = [];
            for (const submission of data.submissions) {
                submissions.push(new TaskSubmission(submission));
            }
            this.submissions = submissions;
        }
    }
}
