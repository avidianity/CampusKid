import TimestampContract from "./TimestampContract";

export default interface FileContract extends TimestampContract {
    id?: number;
    name: string;
    type: string;
    url: string;
    real_name: string;
}
