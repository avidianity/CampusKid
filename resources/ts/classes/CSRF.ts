export class CSRFTokenException extends Error {
    constructor(message: string) {
        super(message);
    }
}
