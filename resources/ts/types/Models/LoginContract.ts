import UserContract from "./UserContract";
import TokenContract from "./TokenContract";

export default interface LoginContract {
    id?: number;
    user_agent: string;
    ip_address: string;
    user_id: number;
    token_id: number;
    user?: UserContract;
    token?: TokenContract;
    date: Date;
}
