import TimestampContract from "./TimestampContract";
import ClassroomContract from "./ClassroomContract";

export default interface StudentContract extends TimestampContract {
    id?: number;
    code: string;
    name: string;
    description: string | null;
    units: number;
    classrooms?: Array<ClassroomContract>;
}
