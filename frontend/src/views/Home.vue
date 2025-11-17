<template>
  <div class="main-container container-fluid"> 

    <!-- Header -->
    <header class="app-header">

      <!-- ROW 1 -->
      <div class="header-row">
        <div class="left-group">
          <img src="/vite.svg" alt="logo" class="app-logo" />
        </div>

        <!-- Desktop Navigation -->
        <nav class="nav-desktop">
          <span
            v-for="item in menuItems.slice(0, -1)"
            :key="item.name"
            @click="setActive(item.name)"
            :class="['nav-item', { active: activePage === item.name }]"
          >
            {{ item.label }}
          </span>
        </nav>

        <!-- Desktop Logout -->
        <span class="logout-btn d-none d-md-block" @click="setActive('Logout')">Logout</span>

        <!-- Mobile Hamburger -->
        <button v-if="!isMenuOpen" class="hamburger-btn d-md-none" @click="isMenuOpen = true">
          <span></span><span></span><span></span>
        </button>

        <!-- Mobile Close X -->
        <button v-if="isMenuOpen" class="close-btn d-md-none" @click="isMenuOpen = false">✕</button>
      </div>

      <!-- ROW 2 : Mobile Dropdown -->
      <div v-if="isMenuOpen" class="mobile-menu d-md-none">
        <span
          v-for="item in menuItems"
          :key="item.name"
          @click="setActive(item.name); isMenuOpen = false"
          class="mobile-nav-item"
          :class="{ active: activePage === item.name }"
        >
          {{ item.label }}
        </span>
      </div>

    </header>

    <!-- Page Label -->
    <div class="page-label mt-3">
      {{ activePage }}
    </div>

    <!-- Dynamic Content -->
    <div class="content-container mt-3 overflow-auto">
      <component :is="currentComponent"></component>
    </div>

  </div>
</template>


<script setup>
import { ref, computed } from "vue";
import { useRouter } from "vue-router";

import Patients from "../views/Patients.vue";
import Claims from "../views/Claims.vue";
import BenefitSetup from "../views/BenefitSetup.vue";
import Reports from "../views/Reports.vue";
import User from "./User.vue";
import Profile from "../views/Profile.vue";

const router = useRouter();

const activePage = ref("Patients");
const isMenuOpen = ref(false);

const menuItems = [
  { name: "Patients", label: "Patients" },
  { name: "Claims", label: "Claims" },
  { name: "BenefitSetup", label: "Benefit Setup" },
  { name: "Reports", label: "Reports" },
  { name: "User", label: "User" },
  { name: "Profile", label: "Profile" },
  { name: "Logout", label: "Logout" },
];

function setActive(name) {
  isMenuOpen.value = false;

  if (name === "Logout") {
    if (confirm("Are you sure you want to logout?")) {
      localStorage.removeItem("isLoggedIn");
      router.push("/login");
    }
    return;
  }

  activePage.value = name;
}

const currentComponent = computed(() => {
  switch (activePage.value) {
    case "Claims": return Claims;
    case "BenefitSetup": return BenefitSetup;
    case "Reports": return Reports;
    case "User": return User;
    case "Profile": return Profile;
    default: return Patients;
  }
});
</script>


<style scoped>
.main-container {
  max-width: 1300px;
  margin: auto;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
  letter-spacing: 0.3px;
  padding: 0.2rem;
}

/* HEADER */
.app-header {
  border-radius: 8px;
  padding: 0.7rem 1rem;
  background: white;
  display: flex;
  flex-direction: column;
}

.header-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

/* LOGO */
.left-group {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.app-logo {
  width: 40px;
  height: 40px;
  border-radius: 6px;
}

/* DESKTOP NAV */
.nav-desktop {
  display: flex;
  align-items: center;
  gap: 2.5rem;
  margin: 0 2rem;
}

.nav-item {
  font-size: 16px;
  font-weight: 500;
  color: #6b7280;
  cursor: pointer;
  padding-bottom: 6px;
  border-bottom: 2px solid transparent;
  transition: 0.2s;
}

.nav-item.active {
  color: #374151;
  border-bottom-color: #2563eb;
}

.nav-item:hover {
  color: #374151;
}

/* LOGOUT */
.logout-btn {
  font-size: 15px;
  font-weight: 600;
  color: #dc2626;
  cursor: pointer;
}

/* CONTENT */
.content-container {
  background: transparent;
  padding: 0 !important;
}

.hamburger-btn {
  width: 26px;
  height: 22px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  background: none;
  border: none;
  cursor: pointer;
  padding: 0;
}

.hamburger-btn span {
  width: 100%;
  height: 3px;
  background-color: #1f2937 !important;
  border-radius: 2px;
  display: block;
}


/* DROPDOWN MENU */
.mobile-menu {
  width: 100%;
  background: white;
  border-top: 1px solid #e5e7eb;
  border-bottom: 1px solid #e5e7eb;
  display: flex;
  flex-direction: column;
  padding: 1rem;
  animation: dropdown 0.2s ease;
}

.mobile-nav-item {
  padding: 12px 10px;
  font-size: 16px;
  text-align: left;
  color: #1f2937;
  border-bottom: 1px solid #f1f5f9;
  cursor: pointer;
}

.mobile-nav-item:last-child {
  border-bottom: none;
}

.mobile-nav-item.active {
  color: #2563eb;
  font-weight: 600;
}

/* CLOSE BUTTON */
.close-btn {
  background: none;
  border: none;
  font-size: 26px;
  font-weight: bold;
  cursor: pointer;
  color: #1f2937;
}

/* PAGE LABEL */
.page-label {
  border-bottom: 1px solid #e5e7eb;
  border-radius: 6px;
  padding: 12px 16px;
  font-size: 18px;
  font-weight: 600;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

/* MOBILE RULES */
@media (max-width: 768px) {
  .nav-desktop { display: none !important; }
  .logout-btn { display: none; }
}
</style>
