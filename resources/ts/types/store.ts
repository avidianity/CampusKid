import * as Collections from "@classes/Collections";

import * as Models from "@classes/Models";

export interface RootState {
    departments: Collections.DepartmentCollection;
    occupations: Collections.OccupationCollection;
    administrators: Collections.AdministratorCollection;
    faculties: Collections.FacultyCollection;
    students: Collections.StudentCollection;
    classrooms: Collections.ClassroomCollection;
    subjects: Collections.SubjectCollection;
    route: string;
    loads: LoadsContract;
    loadErrors: LoadErrorsContract;
    shows: TogglesContract;
}

export interface UserState {
    user: Models.User | null;
    logged: boolean;
    profile?: Models.File;
    cover?: Models.File;
    tokens: Array<Models.Token>;
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

export interface LoadsContract {
    departments: boolean;
    occupations: boolean;
    administrators: boolean;
    faculties: boolean;
    students: boolean;
    classrooms: boolean;
    subjects: boolean;
}

export interface LoadErrorsContract {
    departments: boolean;
    occupations: boolean;
    administrators: boolean;
    faculties: boolean;
    students: boolean;
    classrooms: boolean;
    subjects: boolean;
}

export interface TogglesContract {
    contentHeader: boolean;
}
