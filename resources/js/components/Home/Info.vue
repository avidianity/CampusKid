<template>
    <div class="row my-5 bg-emperor">
        <div class="col-sm-12 col-md-6 text-center p-5">
            <h2>For Teachers</h2>
            <div class="card-padding">
                <div class="card rounded-circle">
                    <img
                        src="@assets/teacher.svg"
                        alt=""
                        class="card-img rounded-circle border shadow"
                    />
                    <div
                        class="card-img-overlay d-flex bg-tradewind rounded-circle hover-show"
                    >
                        <p class="card-text align-self-center text-white">
                            If you are looking to incorporate more digital
                            content in your curriculum and looking for a robust
                            platform that is affordable then CampusKid may be a
                            perfect fit for you.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 text-center p-5">
            <h2>For Students</h2>
            <div class="card-padding">
                <div class="card rounded-circle">
                    <img
                        src="@assets/student.svg"
                        alt=""
                        class="card-img rounded-circle border shadow"
                    />
                    <div
                        class="card-img-overlay d-flex bg-tradewind rounded-circle hover-show"
                    >
                        <p class="card-text align-self-center text-white">
                            CampusKid makes it possible to achieve higher
                            student motivation and increased learning through
                            online tools and class activities.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.card-padding {
    padding: 0 1rem;
}

.card-text {
    font-size: 16px;
}

@media (min-width: 768px) {
    .card-padding {
        padding: 0 2rem;
    }
}

.card-text {
    font-family: "Lato-Light";
}
</style>
