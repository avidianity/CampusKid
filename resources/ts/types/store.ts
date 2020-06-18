import {
    DepartmentCollection,
    OccupationCollection
} from "@classes/Collections";

import { UserContract } from "./Models";

export interface RootState {
    departments: DepartmentCollection;
    occupations: OccupationCollection;
}

export interface UserState {
    user?: UserContract;
    logged: boolean;
    [key: string]: any;
}

export interface SignUpFormContract {
    user: {
        access_level: number | null;
        email: string | null;
        username: string | null;
        password: string | null;
    };
    detail: {
        first_name: string | null;
        last_name: string | null;
        gender: string | null;
        birthday: string | null;
        address: string | null;
    };
    role: {
        department_id: number | null;
        occupation_id: number | null;
    };
}
