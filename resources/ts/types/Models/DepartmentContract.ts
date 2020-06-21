import TimestampContract from "./TimestampContract";

export default interface DepartmentContract extends TimestampContract {
    id?: number;
    name: string;
    abbreviation: string;
}
