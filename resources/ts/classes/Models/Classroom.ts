import { ClassroomContract } from "~types/Models";
import Model from "./Model";
import { File, Faculty, Student, Department, Subject } from "@classes/Models";

export default class Classroom extends Model implements ClassroomContract {
    id?: number;
    name: string;
    description: string | null;
    token: string;
    profile_picture_id: number | null;
    profile_picture?: File | null;
    cover_photo_id: number | null;
    cover_photo?: File | null;
    faculty_id: number;
    faculty?: Faculty;
    department_id: number;
    department?: Department;
    subject_id: number;
    subject?: Subject;
    students?: Array<Student>;
    constructor(data: any) {
        super(data);
        this.id = data.id;
        this.name = data.name;
        this.description = data.description;
        this.token = data.token;
        this.profile_picture_id = data.profile_picture_id;
        this.cover_photo_id = data.cover_photo_id;
        this.subject_id = data.subject_id;
        this.faculty_id = data.faculty_id;
        this.department_id = data.department_id;
        if (data.profile_picture) {
            this.profile_picture = new File(data.profile_picture);
        }
        if (data.cover_photo) {
            this.cover_photo = new File(data.cover_photo);
        }
        if (data.faculty) {
            this.faculty = new Faculty(data.faculty);
        }
        if (data.department) {
            this.department = new Department(data.department);
        }
        if (data.subject) {
            this.subject = new Subject(data.subject);
        }
        if (data.students) {
            const students: Array<Student> = [];
            for (const student of data.students) {
                students.push(new Student(student));
            }
            this.students = students;
        }
    }
}
