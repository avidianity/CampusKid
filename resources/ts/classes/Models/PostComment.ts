import { PostCommentContract } from "~types/Models";
import Model from "./Model";
import { Post, User, File } from "@classes/Models";

export default class PostComment extends Model implements PostCommentContract {
    id?: number;
    body: string;
    post_id: number;
    user_id: number;
    post?: Post;
    user?: User;
    files?: Array<File>;
    constructor(data: any) {
        super(data);
        this.id = data.id;
        this.body = data.body;
        this.post_id = data.post_id;
        this.user_id = data.user_id;
        if (data.post) {
            this.post = new Post(data.post);
        }
        if (data.user) {
            this.user = new User(data.user);
        }
        if (data.files) {
            const files: Array<File> = [];
            for (const file of data.files) {
                files.push(new File(file));
            }
            this.files = files;
        }
    }
}
