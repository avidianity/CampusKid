import TimestampContract from "./TimestampContract";
import DepartmentContract from "./DepartmentContract";
import OccupationContract from "./OccupationContract";
import UserContract from "./UserContract";

export default interface FacultyContract extends TimestampContract {
    id?: number;
    department_id: number;
    occupation_id: number;
    department?: DepartmentContract;
    occupation?: OccupationContract;
    user_id: number;
    user?: UserContract;
}
