export default class Message {
    classes: Object;
    message: string;
    constructor(message: string, classes: Array<string>) {
        this.classes = {};
        for (const style of classes) {
            this.classes[style] = true;
        }
        this.message = message;
    }
}
