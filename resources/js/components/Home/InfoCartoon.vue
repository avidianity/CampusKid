<template>
    <div class="row my-5">
        <div class="col-sm-12 col-md-4 text-center p-4">
            <div class="card-padding">
                <div class="card card-custom">
                    <img
                        src="@assets/conference.png"
                        alt=""
                        class="card-img card-img-custom"
                    />
                    <div class="card-img-overlay card-img-overlay-custom">
                        <h4 class="card-title card-title-custom">
                            Communication
                            <i class="fas fa-users"></i>
                        </h4>
                        <p class="card-text card-text-custom">
                            Online discussions promote collaborative
                            explorations and critical thinking and hence foster
                            deeper understanding.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 text-center p-4">
            <div class="card-padding">
                <div class="card card-custom">
                    <img
                        src="@assets/network.png"
                        alt=""
                        class="card-img card-img-custom"
                    />
                    <div class="card-img-overlay card-img-overlay-custom">
                        <h4 class="card-title card-title-custom">
                            Interactive
                            <i class="fas fa-border-all"></i>
                        </h4>
                        <p class="card-text card-text-custom">
                            Digital curricula can be easily given to students,
                            which is more fun for them. When interacting with
                            digital activities, students often don't perceive it
                            as 'work.' CampusKid makes it possible to achieve
                            higher student motivation and increased learning
                            through online tools and class activities.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 text-center p-4">
            <div class="card-padding">
                <div class="card card-custom">
                    <img
                        src="@assets/list.png"
                        alt=""
                        class="card-img card-img-custom"
                    />
                    <div class="card-img-overlay card-img-overlay-custom">
                        <h4 class="card-title card-title-custom">
                            Grade System
                            <i class="fas fa-book"></i>
                        </h4>
                        <p class="card-text card-text-custom">
                            Any assignment or quiz you post to your digital
                            class will result in a column being added in the
                            Gradebook. Your students' grades are automatically
                            entered in the Gradebook when you grade on the
                            relevant quiz or assignment section.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss">
.card-padding {
    padding: 0rem 4rem;
}

@media (min-width: 576px) {
    .card-padding {
        padding: 2rem;
    }
}

.card-img-overlay-custom {
    background-color: rgba(50, 50, 80, 0.8);
    transition: 0.5s ease;
    opacity: 0;
}

.card-img-overlay-custom:hover {
    opacity: 1;
    cursor: pointer;
}

.card-title-custom {
    color: #fff;
    font-size: 30px;
    font-family: "Lato-Regular";
    margin-bottom: 6px;
}

.card-text-custom {
    color: #fff;
    text-align: left;
    font-size: 16px;
    text-indent: 2em;
    padding-top: 6px;
    border-top: 1px solid #fff;
}
</style>
