import SessionContract, {
    StateContract,
    ExpiringStateContract,
    ExpiryContract,
    FlashStateContract,
    NonPersistingStateContract
} from "~types/Session";
import { User } from "@models/index";

export default class Session implements SessionContract {
    key: string;
    token_key: string;
    Storage: typeof window.localStorage;
    state: StateContract;
    temp: ExpiringSession;
    flash: FlashSession;
    nonpersisting: NonPersistingSession;
    [key: string]: any;
    constructor() {
        this.key = "vue-session-key";
        this.token_key = "vue-token-key";
        this.Storage = window.localStorage;
        this.state = {};
        this.temp = new ExpiringSession(this);
        this.flash = new FlashSession(this);
        this.nonpersisting = new NonPersistingSession();
    }
    start() {
        const data = this.getAll() as StateContract;
        data["session-id"] = `sess:${Date.now()}`;
        return this.setAll(data);
    }
    has(key: string): boolean {
        return key in this.getAll();
    }
    get(key: string): any {
        const data = this.getAll() as StateContract;
        if (data.hasOwnProperty(key)) {
            return data[key];
        }
        return null;
    }
    set(key: string, data: any): this {
        console.log(`SessionSet: ${key} = `, data);
        if (key === "session-id" || key === "key") {
            return this;
        }
        const session_data = this.getAll();
        if (!("session-id" in session_data)) {
            this.start();
        }
        return this.setAll({
            ...session_data,
            [key]: data
        });
    }
    renew(clear: boolean = false): this {
        if (clear) {
            this.clear();
            return this.setAll({
                "session-id": `sess:${Date.now()}`
            });
        } else {
            const data = this.getAll() as StateContract;
            data["session-id"] = `sess:${Date.now()}`;
            return this.setAll(data);
        }
    }
    getAll(): object {
        try {
            const data = JSON.parse(this.Storage.getItem(this.key) || "");
            return data;
        } catch (error) {
            return {};
        }
    }
    setAll(data: object) {
        this.state = data;
        this.Storage.setItem(this.key, JSON.stringify(data));
        return this;
    }
    id(): string {
        return this.get("session-id");
    }
    clear(): this {
        this.state = {};
        this.setAll({});
        return this.start();
    }
    remove(key: string): this {
        const data = this.getAll() as any;
        delete data[key];
        this.setAll(data);
        delete this.state;
        delete this[key];
        return this;
    }
    token(token?: string, remember = true): this | string | null {
        if (token !== undefined) {
            if (remember) {
                return this.set(this.token_key, token) as this;
            } else {
                this.nonpersisting.set(this.token_key, token);
                return this;
            }
        }
        if (this.has(this.token_key)) {
            // persisting
            return this.get(this.token_key) as string;
        } else if (this.nonpersisting.has(this.token_key)) {
            // non persisting
            return this.nonpersisting.get(this.token_key) as string;
        }
        return null;
    }
    revokeToken(): this {
        if (this.has(this.token_key)) {
            return this.remove(this.token_key);
        } else if (this.nonpersisting.has(this.token_key)) {
            this.nonpersisting.remove(this.token_key);
            return this;
        }
        return this;
    }
    hasToken(): boolean {
        return (
            this.has(this.token_key) || this.nonpersisting.has(this.token_key)
        );
    }
    user(user?: User, remember = true): User | this | null {
        if (user !== undefined) {
            if (remember) {
                return this.set("user-session", user);
            } else {
                this.nonpersisting.set("user-session", user);
                return this;
            }
        }
        if (this.has("user-session")) {
            // persisting
            return this.get("user-session");
        } else if (this.nonpersisting.has("user-session")) {
            // non persisting
            return this.nonpersisting.get("user-session");
        }
        return null;
    }
}

export class SessionException extends Error {
    constructor(message: string) {
        super(message);
    }
}

export class ExpiringSession implements ExpiringStateContract {
    id: string;
    key: string;
    parent: Session;
    constructor(parent: Session) {
        this.id = `sess-temp:${Date.now()}`;
        this.key = "vue-expiring-session-key";
        this.parent = parent;
        if (!("session-id" in this.getAll())) {
            this.setAll({
                "session-id": this.id
            });
        }
    }
    getAll(): any {
        try {
            const data = this.parent.get(this.key);
            return data !== null ? data : {};
        } catch (error) {
            return {};
        }
    }
    get(key: string): any {
        const session = this.getAll();
        if (!(key in session)) {
            return null;
        }
        const now = new Date(Date.now());
        const data = session[key] as ExpiryContract;
        const expiry = new Date(data.expiry);
        if (now > expiry) {
            this.remove(key);
            return null;
        }
        return data.value;
    }
    setAll(data: any): this {
        this.parent.set(this.key, data);
        return this;
    }
    set(key: string, value: any, minutes: number): this {
        console.log(`ExpiringSessionSet: ${key} = `, value);
        const data: ExpiryContract = {
            value,
            expiry: new Date(Date.now() + minutes * 60 * 1000).getTime()
        };
        const session = this.getAll();
        session[key] = data;
        this.setAll(session);
        return this;
    }
    remove(key: string): this {
        const data = this.getAll();
        if (key in data) {
            delete data[key];
            this.setAll(data);
        }
        return this;
    }
    clear(): this {
        this.setAll({});
        return this;
    }
    has(key: string): boolean {
        const session = this.getAll();
        if (!(key in session)) {
            return false;
        }
        const now = new Date(Date.now());
        const data = session[key] as ExpiryContract;
        const expiry = new Date(data.expiry);
        if (now > expiry) {
            this.remove(key);
            return false;
        }
        return true;
    }
    renew(clear: boolean = false): this {
        this.id = `sess-temp:${Date.now()}`;
        if (clear) {
            return this.setAll({
                "session-id": this.id
            });
        } else {
            const data = this.getAll();
            data["session-id"] = this.id;
            return this.setAll(data);
        }
    }
}

export class FlashSession implements FlashStateContract {
    key: string;
    parent: Session;
    constructor(session: Session) {
        this.key = "vue-flash-session-key";
        this.parent = session;
        const state = this.getAll();
        if (state === null) {
            this.setAll({});
        } else {
            this.setAll(state);
        }
    }
    get(key: string): any {
        const data = this.getAll();
        const value = data[key];
        this.remove(key);
        return value;
    }
    set(key: string, value: any): this {
        console.log(`FlashSessionSet: ${key} = `, value);
        const data = this.getAll();
        data[key] = value;
        return this.setAll(data);
    }
    getAll(): any {
        const state = this.parent.get(this.key);
        if (state === null) {
            return {};
        }
        return state;
    }
    setAll(data: any): this {
        this.parent.set(this.key, data);
        return this;
    }
    has(key: string): boolean {
        return key in this.getAll();
    }
    remove(key: string): this {
        const data = this.getAll();
        delete data[key];
        this.setAll(data);
        return this;
    }
    clear(): this {
        return this.setAll({});
    }
}

export class NonPersistingSession implements NonPersistingStateContract {
    key: string;
    Storage: typeof window.sessionStorage;
    constructor() {
        this.key = "vue-non-persisting-session-key";
        this.Storage = window.sessionStorage;
    }
    get(key: string): any {}
    getAll(): object {
        try {
            return JSON.parse(this.Storage.getItem(this.key) || "");
        } catch (error) {
            return {};
        }
    }
    set(key: string, value: any): this {
        const data = this.getAll() as any;
        data[key] = value;
        return this.setAll(data);
    }
    setAll(data: object): this {
        this.Storage.setItem(this.key, JSON.stringify(data));
        return this;
    }
    remove(key: string): this {
        const data = this.getAll() as any;
        delete data[key];
        return this.setAll(data);
    }
    clear(): this {
        return this.setAll({});
    }
    has(key: string): boolean {
        return key in this.getAll();
    }
}
