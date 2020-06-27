import { TaskSubmissionContract } from "~types/Models";
import Model from "./Model";
import { Student, File, Task } from "@classes/Models";

export default class TaskSubmission extends Model
    implements TaskSubmissionContract {
    id?: number;
    remarks: string;
    task_id: number;
    task?: Task;
    student_id: number;
    student?: Student;
    files?: Array<File>;
    constructor(data: any) {
        super(data);
        this.id = data.id;
        this.remarks = data.remarks;
        this.task_id = data.task_id;
        this.student_id = data.student_id;
        if (data.task) {
            this.task = new Task(data.task);
        }
        if (data.student) {
            this.student = new Student(data.student);
        }
        if (data.files) {
            const files: Array<File> = [];
            for (const file of data.files) {
                files.push(new File(file));
            }
            this.files = files;
        }
    }
}
