import TimestampContract from "./TimestampContract";

export default interface OccupationContract extends TimestampContract {
    id?: number;
    name: string;
}
