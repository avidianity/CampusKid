import { UserContract } from "~types/Models";
import Model from "./Model";
import AccessLevels from "~types/AccessLevels";

export default class User extends Model implements UserContract {
    id: number;
    provider_id: string;
    provider_type: string;
    email: string;
    role_id: number;
    role_type: string;
    username: string;
    password: string;
    access_level: number | string;
    profile_picture_id: number | null;
    cover_photo_id: number | null;
    access_levels: typeof AccessLevels;
    constructor(data: UserContract) {
        super(data);
        this.id = data.id;
        this.provider_id = data.provider_id;
        this.provider_type = data.provider_type;
        this.email = data.email;
        this.role_id = data.role_id;
        this.role_type = data.role_type;
        this.username = data.username;
        this.password = data.password;
        this.access_level = data.access_level;
        this.profile_picture_id = data.profile_picture_id;
        this.cover_photo_id = data.cover_photo_id;
        this.access_levels = {
            1: "Student",
            2: "Faculty",
            3: "Administrator",
            Student: 1,
            Faculty: 2,
            Administrator: 3
        };
    }
    isStudent(): boolean {
        const role = this.access_levels[this.access_level];
        return role === "Student" || role === 1;
    }
    isFaculty(): boolean {
        const role = this.access_levels[this.access_level];
        return role === "Faculty" || role === 2;
    }
    isAdministrator(): boolean {
        const role = this.access_levels[this.access_level];
        return role === "Administrator" || role === 3;
    }
}
