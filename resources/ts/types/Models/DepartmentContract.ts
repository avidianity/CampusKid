import TimestampContract from "./TimestampContract";
import FacultyContract from "./FacultyContract";
import StudentContract from "./StudentContract";

export default interface DepartmentContract extends TimestampContract {
    id?: number;
    name: string;
    abbreviation: string;
    faculties?: Array<FacultyContract>;
    students?: Array<StudentContract>;
}
