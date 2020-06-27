import { PostContract } from "~types/Models";
import Model from "./Model";
import { User, Classroom, PostComment, File } from "@classes/Models";

export default class Post extends Model implements PostContract {
    id?: number;
    body: string;
    user_id: number;
    classroom_id: number;
    user?: User;
    classroom?: Classroom;
    comments?: Array<PostComment>;
    files?: Array<File>;
    constructor(data: any) {
        super(data);
        this.id = data.id;
        this.body = data.body;
        this.user_id = data.user_id;
        this.classroom_id = data.classroom_id;
        if (data.user) {
            this.user = new User(data.user);
        }
        if (data.classroom) {
            this.classroom = new Classroom(data.classroom);
        }
        if (data.comments) {
            const comments: Array<PostComment> = [];
            for (const comment of data.comments) {
                comments.push(new PostComment(comment));
            }
            this.comments = comments;
        }
        if (data.files) {
            const files: Array<File> = [];
            for (const comment of data.files) {
                files.push(new File(comment));
            }
            this.files = files;
        }
    }
}
