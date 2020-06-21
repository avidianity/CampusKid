import TimestampContract from "./TimestampContract";
import DepartmentContract from "./DepartmentContract";
import UserContract from "./UserContract";

export default interface StudentContract extends TimestampContract {
    id?: number;
    user_id: number;
    department_id: number;
    department?: DepartmentContract;
    user?: UserContract;
}
