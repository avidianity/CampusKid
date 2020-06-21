<template>
    <aside class="main-sidebar elevation-4 sidebar-light-primary">
        <a href="#" class="brand-link">
            <img
                src="@assets/logo.png"
                alt="CampusKid Logo"
                class="brand-image img-circle elevation-3"
                style="opacity: .8"
            />
            <span class="brand-text font-weight-light">CampusKid</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul
                    class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-compact nav-flat"
                    data-widget="treeview"
                    role="menu"
                    data-accordion="false"
                >
                    <slot></slot>
                </ul>
            </nav>
        </div>
    </aside>
</template>
