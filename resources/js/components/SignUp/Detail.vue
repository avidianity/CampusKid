<template>
    <div class="container pt-3">
        <div class="row">
            <div class="col-sm-12 col-md-8 offset-md-2">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <label for="first_name">First Name:</label>
                        <input
                            type="text"
                            name="first_name"
                            placeholder="First Name"
                            class="form-control form-control-sm"
                        />
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label for="last_name">Last Name:</label>
                        <input
                            type="text"
                            name="last_name"
                            id="last_name"
                            placeholder="Last Name"
                            class="form-control form-control-sm"
                        />
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label for="gender">Gender</label>
                        <select
                            name="gender"
                            id="gender"
                            class="form-control form-control-sm"
                        >
                            <option value="Male">
                                Male
                            </option>
                            <option value="Female">
                                Female
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label for="birthday">Birthday:</label>
                        <input
                            type="date"
                            name="birthday"
                            id="birthday"
                            placeholder="Birthday"
                            class="form-control form-control-sm"
                        />
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label for="address">Address:</label>
                        <input
                            type="text"
                            name="address"
                            id="address"
                            placeholder="Address"
                            class="form-control form-control-sm"
                        />
                    </div>
                    <div class="col-sm-12 mt-3">
                        <button type="submit" class="btn btn-emperor btn-sm">
                            Create Account
                        </button>
                        <small class="form-text text-muted">
                            By creating an account, you agree to our
                            <router-link to="/privacy-policy">
                                Privacy policy
                            </router-link>
                            and
                            <router-link to="/terms-of-service">
                                Terms of Service.
                            </router-link>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
label {
    margin: 12px 0 4px 0;
    font-family: "Lato-Light";
}

.form-control,
.btn {
    border-radius: 20px;
}
</style>
