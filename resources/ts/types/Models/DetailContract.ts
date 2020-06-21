import TimestampContract from "./TimestampContract";

export default interface DetailContract extends TimestampContract {
    id?: number;
    first_name: string;
    last_name: string;
    gender: string;
    birthday: Date | string;
    address: string;
    user_id: number;
}
