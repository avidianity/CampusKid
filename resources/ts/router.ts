import Vue from "vue";
import VueRouter, { RouteConfig } from "vue-router";

/**
 * Static and Starter
 */
import IndexPage from "@views/Index.vue";
import SignUpPage from "@views/SignUp.vue";
import SignInPage from "@views/SignIn.vue";
import PolicyPage from "@views/Policy.vue";
import TermsPage from "@views/Terms.vue";

/**
 * Dynamic App loading,
 * Loads: Admin, Faculty, Student Dashboards
 */
import DashboardPage from "@views/Dashboard.vue";
import MainDashboardPage from "@views/MainDashboard.vue";

/**
 * Users
 */
import UsersIndexPage from "@views/Users/Index.vue";
import AdministratorsPage from "@views/Users/Administrator.vue";
import FacultiesPage from "@views/Users/Faculty.vue";
import StudentsPage from "@views/Users/Student.vue";
import UsersPage from "@views/Users/User.vue";

/**
 * Adds
 */
import AddIndexPage from "@views/Add/Index.vue";
import AddUserPage from "@views/Add/User.vue";
import AddAdministratorPage from "@views/Add/Administrator.vue";
import AddFacultyPage from "@views/Add/Faculty.vue";
import AddStudentPage from "@views/Add/Student.vue";
import AddDepartmentPage from "@views/Add/Department.vue";
import AddOccupationPage from "@views/Add/Occupation.vue";
import AddSubjectPage from "@views/Add/Subject.vue";

/**
 * Classroom
 */
import ClassroomIndexPage from "@views/Classroom/Index.vue";
import ClassroomListPage from "@views/Classroom/List.vue";
import ClassroomPage from "@views/Classroom/Classroom.vue";

/**
 * Singles
 */
import DepartmentPage from "@views/Singles/Department.vue";
import OccupationPage from "@views/Singles/Occupation.vue";
import SubjectPage from "@views/Singles/Subject.vue";

/**
 * Error Pages
 */
import FourZeroFour from "@views/404.vue";
import Dashboard404 from "@components/Dashboard404.vue";
import Dashboard503 from "@components/Dashboard503.vue";

Vue.use(VueRouter);

import Guards from "@classes/Guards";

const FZF: RouteConfig = {
	path: "*",
	component: Dashboard404,
};

const router = new VueRouter({
	mode: "history",
	linkActiveClass: "active",
	linkExactActiveClass: "active",
	routes: [
		{
			path: "/",
			name: "index",
			component: IndexPage,
		},
		{
			path: "/sign-up",
			name: "Sign-Up",
			component: SignUpPage,
		},
		{
			path: "/sign-in",
			name: "Sign-In",
			component: SignInPage,
		},
		{
			path: "/privacy-policy",
			name: "Privacy-Policy",
			component: PolicyPage,
		},
		{
			path: "/terms-of-service",
			name: "Terms-of-Service",
			component: TermsPage,
		},
		{
			path: "/dashboard",
			component: DashboardPage,
			beforeEnter: Guards.isAdmin(),
			children: [
				{
					path: "",
					component: MainDashboardPage,
					name: "Dashboard",
				},
				{
					path: "users",
					component: UsersIndexPage,
					children: [
						{
							path: "",
							component: UsersPage,
							name: "Users",
						},
						{
							path: "administrators",
							component: AdministratorsPage,
							name: "Administrators",
						},
						{
							path: "faculties",
							component: FacultiesPage,
							name: "Faculties",
						},
						{
							path: "students",
							component: StudentsPage,
							name: "Students",
						},
						{
							path: "add",
							component: AddIndexPage,
							children: [
								{
									path: "",
									component: AddUserPage,
									name: "Add User",
								},
								{
									path: "administrator",
									component: AddAdministratorPage,
									name: "Add Administrator",
								},
								{
									path: "faculty",
									component: AddFacultyPage,
									name: "Add Faculty",
								},
								{
									path: "student",
									component: AddStudentPage,
									name: "Add Student",
								},
								FZF,
							],
						},
						FZF,
					],
				},
				{
					path: "classrooms",
					component: ClassroomIndexPage,
					children: [
						{
							path: "",
							component: ClassroomListPage,
							name: "Classrooms",
						},
						{
							path: ":id",
							component: ClassroomPage,
							name: "",
						},
						FZF,
					],
				},
				{
					path: "departments",
					component: DepartmentPage,
					name: "Departments",
				},
				{
					path: "occupations",
					component: OccupationPage,
					name: "Occupations",
				},
				{
					path: "subjects",
					component: SubjectPage,
					name: "Subjects",
				},
				{
					path: "activities",
					component: Dashboard503,
					name: "Activities",
				},
				/**
				 * Non-user Adds
				 */
				{
					path: "add",
					component: AddIndexPage,
					children: [
						{
							path: "department",
							component: AddDepartmentPage,
							name: "Add Department",
						},
						{
							path: "occupation",
							component: AddOccupationPage,
							name: "Add Occupation",
						},
						{
							path: "subject",
							component: AddSubjectPage,
							name: "Add Subject",
						},
						FZF,
					],
				},
				FZF,
			],
		},
		{
			path: "/*",
			component: FourZeroFour,
		},
	],
});

import store from "@store/index";

router.beforeEach((to, from, next) => {
	store.dispatch("setRoute", to.name);
	store.dispatch("toggleContentHeader", true);
	next();
});

export default router;
