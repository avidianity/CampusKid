<template>
    <div class="row px-5">
        <div class="col-sm-12 col-md-6">
            <h1 class="title">
                Make Learning and Teaching Easier
            </h1>
            <p class="lead">
                We help teachers and students learn better through interactive,
                real-time and secure services. From conducting classes to open
                discussions as well as tasking with homeworks and many more. We
                handle it all for you!
            </p>
            <router-link to="/sign-up" class="btn btn-cutty-sark">
                Get Started
            </router-link>
        </div>
        <div class="col-sm-12 col-md-6 py-3 pr-3">
            <img src="@assets/intro.png" alt="" class="img-fluid" />
        </div>
    </div>
</template>

<style lang="scss" scoped>
.btn {
    padding: 6px 24px;
    border-radius: 20px;
    font-family: "Lato-Bold";
}
.lead {
    text-indent: 24px;
    font-size: 18px;
    font-family: "Lato-Light";
    line-height: 30px;
}

.title {
    margin-top: 12px;
    font-size: 46px;
}
</style>
