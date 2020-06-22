import store from "@store/index";
import { User } from "@classes/Models/index";
import { NavigationGuard } from "vue-router";

class Guards {
    isAdmin(): NavigationGuard {
        return (to, from, next) => {
            let user = store.getters.user as User;
            if (!user) {
                user = Session.user() as User;
            }
            if (user && user.isAdministrator()) {
                next();
            } else {
                next({
                    path: from.path
                });
            }
        };
    }
    isFaculty(): NavigationGuard {
        return (to, from, next) => {
            let user = store.getters.user as User;
            if (!user) {
                user = Session.user() as User;
            }
            if (user && user.isFaculty()) {
                next();
            } else {
                next({
                    path: from.path
                });
            }
        };
    }
    isStudent(): NavigationGuard {
        return (to, from, next) => {
            let user = store.getters.user as User;
            if (!user) {
                user = Session.user() as User;
            }
            if (user && user.isStudent()) {
                next();
            } else {
                next({
                    path: from.path
                });
            }
        };
    }
}

export default new Guards();
