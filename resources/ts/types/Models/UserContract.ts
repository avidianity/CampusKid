import TimestampContract from "./TimestampContract";
import FileContract from "./FileContract";
import StudentContract from "./StudentContract";
import FacultyContract from "./FacultyContract";
import AdministratorContract from "./AdministratorContract";
import DetailContract from "./DetailContract";

export default interface UserContract extends TimestampContract {
    id?: number;
    provider_id: string;
    provider_type: string;
    email: string;
    role_id: number;
    role_type: string;
    username: string;
    password: string;
    access_level: number | string;
    profile_picture: FileContract | null;
    profile_picture_id: number | null;
    cover_photo: FileContract | null;
    cover_photo_id: number | null;
    role?: StudentContract | FacultyContract | AdministratorContract;
    detail?: DetailContract;
    isStudent(): boolean;
    isFaculty(): boolean;
    isAdministrator(): boolean;
    homeRoute(): object;
}
