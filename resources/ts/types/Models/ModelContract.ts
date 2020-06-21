import TimestampContract from "./TimestampContract";

export default interface ModelContract extends TimestampContract {
    fill(data: any): this;
    save(url: string, headers: Object): Promise<any>;
}
