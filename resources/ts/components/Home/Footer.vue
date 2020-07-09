<template>
    <div class="row mt-5 pt-3 bg-dark footer">
        <div class="col-12">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <h5 class="footer-title">CampusKid.com</h5>
                        <ul class="footer-links">
                            <li class="footer-item">
                                <a href="/" class="footer-link">
                                    Home
                                    <span class="footer-link-line"></span>
                                </a>
                            </li>
                            <li class="footer-item">
                                <router-link to="/about" class="footer-link">
                                    About
                                    <span class="footer-link-line"></span>
                                </router-link>
                            </li>
                            <li class="footer-item">
                                <router-link
                                    to="/privacy-policy"
                                    class="footer-link"
                                >
                                    Privacy Policy
                                    <span class="footer-link-line"></span>
                                </router-link>
                            </li>
                            <li class="footer-item">
                                <router-link
                                    to="/terms-of-service"
                                    class="footer-link"
                                >
                                    Terms of Service
                                    <span class="footer-link-line"></span>
                                </router-link>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <h5 class="footer-title">Support</h5>
                        <ul class="footer-links">
                            <li class="footer-item">
                                <router-link
                                    to="/documentation"
                                    class="footer-link"
                                >
                                    API Reference
                                    <span class="footer-link-line"></span>
                                </router-link>
                            </li>
                            <li class="footer-item">
                                <router-link
                                    to="/documentation"
                                    class="footer-link"
                                >
                                    Documentation
                                    <span class="footer-link-line"></span>
                                </router-link>
                            </li>
                            <li class="footer-item">
                                <router-link to="/help" class="footer-link">
                                    Help
                                    <span class="footer-link-line"></span>
                                </router-link>
                            </li>
                            <li class="footer-item">
                                <router-link to="/contact" class="footer-link">
                                    Contact
                                    <span class="footer-link-line"></span>
                                </router-link>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <h5 class="footer-title">
                            Social Media
                        </h5>
                        <ul class="footer-links d-flex">
                            <li class="footer-item">
                                <a
                                    href="https://www.facebook.com/CampusKid"
                                    class="footer-link social-media-link bg-white text-dark rounded-circle"
                                >
                                    <i class="fab fa-facebook text-blue"></i>
                                </a>
                            </li>
                            <li class="footer-item">
                                <a
                                    href="https://twitter.com/CampusKid"
                                    class="footer-link social-media-link bg-white rounded-circle"
                                >
                                    <i
                                        class="fab fa-twitter text-lightblue"
                                    ></i>
                                </a>
                            </li>
                            <li class="footer-item">
                                <a
                                    href="https://github.com/avidianity/CampusKid"
                                    class="footer-link social-media-link bg-white rounded-circle"
                                >
                                    <i class="fab fa-github text-dark"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.footer {
    border-bottom-right-radius: 11px;
    border-bottom-left-radius: 11px;
    padding-bottom: 20px;
}

.footer-title {
    font-family: "Lato-Light";
    font-size: 26px;
    margin-bottom: 12px;
}

.footer-links {
    list-style-type: none;
    padding: 0;
}

.footer-item {
    margin: 16px 0;
}

.footer-link {
    display: inline-block;
    font-family: "Lato-Regular";
    color: #fff;
    text-decoration: none;
}

.active .footer-link-line {
    width: 100%;
}

.footer-link-line {
    display: block;
    width: 0;
    height: 1px;
    background-color: #fff;
    transition: width 0.4s ease;
}

.footer-link:hover .footer-link-line {
    width: 100%;
}

.social-media-link {
    height: 32px;
    width: 32px;
    display: flex;
    margin: 0 4px;
}

.social-media-link .fab {
    align-self: center;
    margin: auto;
    font-size: 1.5rem;
}
</style>
