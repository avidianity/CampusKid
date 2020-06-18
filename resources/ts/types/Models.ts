export interface TimestampContract {
    created_at: Date;
    updated_at: Date;
}

export interface UserContract extends TimestampContract {
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
    isStudent(): boolean;
    isFaculty(): boolean;
    isAdministrator(): boolean;
    homeRoute(): object;
}

export interface DepartmentContract extends TimestampContract {
    id: number;
    name: string;
    abbreviation: string;
}

export interface OccupationContract extends TimestampContract {
    id: number;
    name: string;
}

export interface DetailContract extends TimestampContract {
    id: number;
    first_name: string;
    last_name: string;
    gender: string;
    birthday: Date | string;
    address: string;
    user_id: number;
}

export interface PaginationContract {
    current_page: number;
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    next_page_url: string;
    path: string;
    per_page: number;
    prev_page_url: string;
    to: number;
    total: number;
    data: Array<any>;
}
