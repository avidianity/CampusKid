<template>
    <nav class="navbar navbar-expand-sm navbar-dark bg-emperor">
        <a class="navbar-brand ml-2" href="#">
            <img
                src="@assets/logo.png"
                height="30"
                width="30"
                alt=""
                class="d-inline-block"
            />
            CampusKid
        </a>
        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mr-2">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        Help
                        <span class="nav-line"></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">
                        Contact
                        <span class="nav-line"></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">
                        Sign In
                        <span class="nav-line"></span>
                    </a>
                </li>
            </ul>
            <router-link
                to="/sign-up"
                class="btn btn-tradewind btn-sm my-2 my-sm-0 mr-2"
            >
                Sign Up
            </router-link>
        </div>
    </nav>
</template>

<style lang="scss" scoped>
@import "@styles/global.scss";

.nav-line {
    display: none;
    width: 0%;
    height: 2px;
    background-color: #fff;
    transition: 0.5s ease;
}

@media (min-width: 576px) {
    .navbar {
        border-top-right-radius: 11px;
        border-top-left-radius: 11px;
    }

    .nav-line {
        display: block;
    }

    .nav-link:hover .nav-line {
        width: 100%;
    }
}

.btn {
    padding: 6px 24px;
    border-radius: 20px;
    font-family: "Lato-Bold";
}
</style>
