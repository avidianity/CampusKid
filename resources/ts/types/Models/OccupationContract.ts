import TimestampContract from "./TimestampContract";
import AdministratorContract from "./AdministratorContract";
import FacultyContract from "./FacultyContract";

export default interface OccupationContract extends TimestampContract {
    id?: number;
    name: string;
    administrators?: Array<AdministratorContract>;
    faculties?: Array<FacultyContract>;
}
