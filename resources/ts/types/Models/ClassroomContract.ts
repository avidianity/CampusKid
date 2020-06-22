import TimestampContract from "./TimestampContract";
import FileContract from "./FileContract";
import FacultyContract from "./FacultyContract";
import StudentContract from "./StudentContract";
import DepartmentContract from "./DepartmentContract";

export default interface ClassroomContract extends TimestampContract {
    id?: number;
    name: string;
    description: string | null;
    token: string;
    profile_picture_id: number | null;
    profile_picture?: FileContract | null;
    cover_photo_id: number | null;
    cover_photo?: FileContract | null;
    subject_id: number;
    faculty_id: number;
    faculty?: FacultyContract;
    department_id: number;
    department?: DepartmentContract;
    students?: Array<StudentContract>;
}
