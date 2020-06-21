import { UserContract } from "~types/Models";
import Model from "./Model";
import AccessLevels from "~types/AccessLevels";
import File from "./File";
import Administrator from "./Administrator";
import Faculty from "./Faculty";
import Student from "./Student";

type Route = {
    path: string;
};

const RoleClass = {
    ["Administrator" as string]: Administrator,
    ["Faculty" as string]: Faculty,
    ["Student" as string]: Student
};

export default class User extends Model implements UserContract {
    id?: number;
    provider_id: string;
    provider_type: string;
    email: string;
    role_id: number;
    role_type: string;
    username: string;
    password: string;
    access_level: number | string;
    profile_picture: File | null;
    profile_picture_id: number | null;
    cover_photo: File | null;
    cover_photo_id: number | null;
    access_levels: typeof AccessLevels;
    role?: Administrator | Faculty | Student;
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
        this.profile_picture = data.profile_picture
            ? new File(data.profile_picture)
            : null;
        this.cover_photo = data.cover_photo ? new File(data.cover_photo) : null;
        this.access_levels = {
            1: "Student",
            2: "Faculty",
            3: "Administrator",
            Student: 1,
            Faculty: 2,
            Administrator: 3
        };
        if (data.role) {
            const key = this.access_level as string;
            this.role = new RoleClass[key](data.role);
        }
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
    homeRoute(): Route {
        if (this.isAdministrator()) {
            return { path: "/dashboard" };
        } else if (this.isFaculty()) {
            return { path: "/faculty" };
        } else if (this.isStudent()) {
            return { path: "/student" };
        }
        throw new UserException("Access Level is undefined.");
    }
    getProfilePicture(): Promise<File> {
        return Axios.get(`/files/${this.profile_picture_id}`)
            .then(response => response.data)
            .then((file: File) => {
                return file;
            })
            .catch(error => {
                return new File({
                    id: 0,
                    name: "placeholder",
                    type: "image/jpg",
                    url: "https://via.placeholder.com/160",
                    created_at: Date.now(),
                    updated_at: Date.now()
                });
            });
    }
}

export class UserException extends Error {}
