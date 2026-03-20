import { createRouter, createWebHistory } from "vue-router";

import login from "../views/login.vue";
import dashboard from "../views/dashboard.vue";
import create from "../views/create.vue";

const routes = [
  { path: "/", redirect: "/login" },

  {
    path: "/login",
    name: "login",
    component: login
  },

  {
    path: "/dashboard",
    name: "dashboard",
    component: dashboard,
    meta: { requiresAuth: true }
  },

  {
    path: "/create-meeting",
    name: "create-meeting",
    component: create,
    meta: { requiresAuth: true }
  },

  {
    path: "/list",
    name: "list",
    component: () => import("../views/list.vue"),
    meta: { requiresAuth: true }
  },

  // ✅ หน้าเพิ่มวาระการประชุม
  {
    path: "/meeting/:id/agendas/create",
    name: "CreateAgendas",
    component: () => import("../views/createAgendas.vue"),
    props: true,
    meta: { requiresAuth: true }
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// 🔐 ตรวจสอบการ login
router.beforeEach((to, from, next) => {
  const user = localStorage.getItem("user");

  if (to.meta.requiresAuth && !user) {
    next("/login");
  }
  else if (to.path === "/login" && user) {
    next("/dashboard");
  }
  else {
    next();
  }
});

export default router;
