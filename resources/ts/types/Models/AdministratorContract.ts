import TimestampContract from "./TimestampContract";
import UserContract from "./UserContract";

export default interface AdministratorContract extends TimestampContract {
    id?: number;
    occupation_id: number;
    user_id: number;
    user?: UserContract;
}
