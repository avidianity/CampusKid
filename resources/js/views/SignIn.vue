<template>
    <div id="root">
        <div class="container-fluid pt-2">
            <div class="row">
                <div
                    class="col-sm-12 col-md-4 offset-md-4 main p-3 rounded mt-5 shadow border"
                >
                    <div class="d-flex">
                        <h2 class="mr-auto">Login</h2>
                        <router-link to="/" class="ml-auto back">
                            <img
                                src="@assets/logo.png"
                                alt=""
                                height="50"
                                width="50"
                                class="rounded-circle border shadow-sm"
                            />
                        </router-link>
                    </div>
                    <label for="credential">Username/Email:</label>
                    <input
                        type="text"
                        name="username"
                        id="credential"
                        placeholder="Username/Email"
                        class="form-control form-control-sm"
                    />
                    <small class="form-text text-muted">
                        Valid username.
                    </small>
                    <label for="password">Password:</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Password"
                        class="form-control form-control-sm"
                    />
                    <button type="submit" class="btn btn-emperor mt-3">
                        Sign In
                    </button>
                    <router-link to="/sign-up" class="btn-link d-block mt-2">
                        Create an Account
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
#root {
    background: url("../assets/bg-home.png") center center;
    background-size: cover;
    background-repeat: no-repeat;
    padding: 20px;
    height: 100vh;
    display: flex;
}

.main {
    background-color: #fff;
    font-family: "Lato-Light";
}

.form-control,
.btn {
    border-radius: 15px;
}

.back {
    cursor: pointer;
}
</style>
