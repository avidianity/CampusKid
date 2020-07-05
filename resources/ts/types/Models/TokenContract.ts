import TimestampContract from "./TimestampContract";
import LoginContract from "./LoginContract";

export default interface TokenContract extends TimestampContract {
    id?: number;
    tokenable_type: string;
    tokenable_id: number;
    name: string;
    abilities: string | Array<string>;
    last_used_at: Date | null;
    login?: LoginContract;
}
