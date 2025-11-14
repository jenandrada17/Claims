<!-- src/App.vue -->
<template>
  <div class="main-container container-fluid">

    <!-- Header -->
    <header class="app-header d-flex align-items-center justify-content-between px-3 py-2">

      <!-- Left: Hamburger + Logo -->
      <div class="d-flex align-items-center gap-3">
        <button class="hamburger-btn d-md-none" @click="isMenuOpen = !isMenuOpen">
          <span class="hamburger-line"></span>
          <span class="hamburger-line"></span>
          <span class="hamburger-line"></span>
        </button>

        <img src="/vite.svg" alt="logo" class="app-logo" />
      </div>

      <!-- Mobile Menu (RIGHT SIDE, dropdown) -->
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

      <!-- Desktop Navigation -->
      <nav class="nav-desktop d-flex align-items-center gap-4">
        <span
          v-for="item in menuItems"
          :key="item.name"
          @click="setActive(item.name)"
          :class="['nav-item', { active: activePage === item.name }]"
        >
          {{ item.label }}
        </span>
      </nav>

    </header>


    <!-- Dynamic Content -->
    <div class="nav-container mt-3 bg-white p-4 shadow-sm rounded overflow-auto">
      <component :is="currentComponent"></component>
    </div>

  </div>
</template>


<script setup>
import { ref, computed } from "vue";
import { useRouter } from "vue-router"; 
// Import components
import Dashboard from "../views/Dashboard.vue";
import Patients from "../views/Patients.vue";
import Claims from "../views/Claims.vue";
import BenefitSetup from "../views/BenefitSetup.vue";
import Reports from "../views/Reports.vue";
import User from "./User.vue";
import Profile from "../views/Profile.vue";

const router = useRouter();
const activePage = ref("Search");
const isMenuOpen = ref(false);

const menuItems = [
  { name: "Dashboard", label: "Dashboard" },
  { name: "Patients", label: "Patients" },
  { name: "Claims", label: "Claims" },
  { name: "BenefitSetup", label: "Benefit Setup" },
  { name: "Reports", label: "Reports" },
  { name: "User", label: "User" },
  { name: "Profile", label: "Profile" },
  { name: "Logout", label: "Logout" },
];

function setActive(name) {
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
    case "Patients":
      return Patients;
    case "Claims":
      return Claims;
    case "BenefitSetup":
      return BenefitSetup;
    case "Reports":
      return Reports;
    case "User":
      return User;
    case "Profile":
      return Profile;
    default:
      return Dashboard;
  }
});
</script>

<style scoped>
/* Import modern font */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

/* Apply globally */
.main-container {
  max-width: 1300px;
  margin: auto;
  font-family: "Inter", system-ui, -apple-system, sans-serif;
  padding: 0.5rem;
}

/* Header */
.app-header {
  background: linear-gradient(90deg, #ffffff, #f2f9ff);
  border: 1px solid #cfe7ff;
  border-radius: 8px;
  display: flex;
  align-items: center;
  gap: 2rem;
  margin-top: 0.5rem;   /* pulls header upward */
}

.app-logo {
  width: 36px;
  height: 36px;
  border-radius: 6px;
}

/* Navigation */
.nav-item {
  font-size: 15px;
  font-weight: 500;
  color: #4b5563;
  cursor: pointer;
  padding-bottom: 6px;
  border-bottom: 2px solid transparent;
  transition: color 0.2s ease, border-color 0.2s ease;
}

.nav-item:hover {
  color: #1f2937;
}

.nav-item.active {
  color: #1d4ed8;
  border-bottom-color: #2563eb;
}

.hamburger-btn {
  background: none;
  border: none;
  padding: 4px;
  display: flex;
  flex-direction: column;
  gap: 3px;
}

.hamburger-line {
  width: 20px;
  height: 3px;
  background-color: #4b5563;
  border-radius: 4px;
} 

.mobile-menu {
  position: absolute;
  right: 20px;
  top: 60px;
  width: 150px;
  background: white;
  border: 1px solid #cfe7ff;
  border-radius: 6px;
  padding: 0.5rem;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  display: flex;
  flex-direction: column;
  z-index: 100;
}

.mobile-nav-item {
  padding: 8px 10px;
  font-size: 14px;
  color: #4b5563;
  border-bottom: 1px solid #e5e7eb;
  cursor: pointer;
}

.mobile-nav-item:last-child {
  border-bottom: none;
}

.mobile-nav-item.active {
  color: #1d4ed8;
  font-weight: 600;
}


/* Responsive */
@media (max-width: 768px) { 
  .nav-desktop {
    display: none !important;
  }
}  

</style>
