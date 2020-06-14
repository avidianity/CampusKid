<template>
    <nav class="nav">
        <ul class="navbar">
            <li class="nav-item">
                <a href="/" class="navbar-brand align-self-center">
                    <img src="@assets/logo.svg" alt="" class="logo" />
                    CampusKid
                </a>
            </li>
        </ul>
        <ul class="navbar ml-auto">
            <li class="nav-item">
                <router-link to="/help" class="nav-link">
                    Help
                    <span class="nav-line"></span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link to="/contact" class="nav-link">
                    Contact
                    <span class="nav-line"></span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link to="/sign-in" class="nav-link">
                    Sign In
                    <span class="nav-line"></span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link to="/sign-up" class="btn btn-tradewind">
                    Sign Up
                </router-link>
            </li>
        </ul>
    </nav>
</template>

<style lang="scss" scoped>
@import "@styles/global.scss";
.logo {
    height: 45px;
    width: 45px;
    border-radius: 50%;
    margin-right: 6px;
}

.navbar-brand {
    font-family: "Lato-Bold";
    font-size: 18px;
    color: #fff;
    margin-left: 6px;
}

.nav {
    background-color: $cutty_sark;
    width: 100%;
    display: block;
    padding: 10px 0;
    display: flex;
    border-top-right-radius: 11px;
    border-top-left-radius: 11px;
}

.navbar {
    list-style-type: none;
    margin: 0;
}

.nav-item {
    margin: 0 16px;
}

.nav-link {
    color: #fff;
    font-family: "Lato-Regular";
    padding-left: 0;
    padding-right: 0;
}

.nav-line {
    display: block;
    width: 0%;
    height: 2px;
    background-color: #fff;
    transition: 0.5s ease;
}

.nav-link:hover .nav-line {
    width: 100%;
}

.btn {
    padding: 6px 24px;
    border-radius: 20px;
    font-family: "Lato-Bold";
}
</style>
