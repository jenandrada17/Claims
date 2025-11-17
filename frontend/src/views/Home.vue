<template>
  <div class="main-container container-fluid"> 
    <!-- Header -->
    <header class="app-header px-3 py-2">

      <!-- Left: Logo -->
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
      <span class="logout-btn d-none d-md-block" @click="setActive('Logout')">
        Logout
      </span>

      <!-- Mobile Hamburger (RIGHT SIDE) -->
      <button class="hamburger-btn d-md-none" @click="isMenuOpen = !isMenuOpen">
        <span></span><span></span><span></span>
      </button>

      <!-- Mobile Menu -->
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
    
    <!-- Page Label / Title -->
    <div class="page-label mt-3">
      {{ activePage }}
    </div>

    <!-- Dynamic Content -->
    <!-- <div class="content-container mt-3 bg-white p-4 shadow-sm rounded overflow-auto">  -->
    <div class="content-container mt-3 overflow-auto"> 
      <component :is="currentComponent"></component>
    </div>

  </div>
</template>


<script setup>
import { ref, computed } from "vue";
import { useRouter } from "vue-router"; 
// Import components 
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

  // SET LABEL FROM MENU AUTOMATICALLY
  const found = menuItems.find(m => m.name === name);
  pageLabel.value = found ? found.label : name;
}

const currentComponent = computed(() => {
  switch (activePage.value) {  
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
      return Patients;
  }
});
 
</script>

<style scoped>  
/* Apply globally */
.main-container {
  max-width: 1300px;
  margin: auto;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
  letter-spacing: 0.3px;
  padding: 0.2rem;
}

/* Header */ 
.app-header {
  border: none; 
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0.7rem 1rem;
  position: relative;
}

/* Left Group (Hamburger + Logo) */
.left-group {
  display: flex;
  align-items: center;
  gap: 1rem;
}

/* Logo */
.app-logo {
  width: 40px;
  height: 40px;
  border-radius: 6px;
}

/* Desktop Navigation */
.nav-desktop {
  display: flex;
  align-items: center;
  gap: 2.5rem; /* MORE SPACE BETWEEN ITEMS */
  margin-left: 2rem;
  margin-right: 2rem;
}

.nav-item {
  font-size: 16px;
  font-weight: 500;
  color: #6b7280;
  cursor: pointer;
  padding-bottom: 6px;
  border-bottom: 2px solid transparent;
  transition: .2s; 
  margin-right: 22px; /* add space between items */
}

.nav-item.active {
  color: #374151;
  border-bottom-color: #2563eb;
}

.nav-item:hover {
  color: #374151;
}

/* Logout Button */
.logout-btn {
  margin-left: auto;
  font-size: 15px;
  font-weight: 600;
  color: #dc2626;
  cursor: pointer;
}

.content-container {
  background: transparent;     /* no white background */
  padding: 0 !important;       /* remove internal padding */
}


/* MUCH BETTER HAMBURGER BUTTON */
:deep(.hamburger-btn) {
  width: 26px;
  height: 22px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  cursor: pointer;
  padding: 0;
  background: none;
  border: none;
}

:deep(.hamburger-btn span) {
  width: 100%;
  height: 3px;
  background-color: #1f2937 !important;
  border-radius: 2px;
  display: block;
}
.hamburger-btn:hover span {
  background: #1f2937;
} 

.mobile-menu {
  position: absolute;
  top: 100%;       /* Attach BELOW the header */
  left: 0;         /* Full width */
  width: 100%;
  background: white;

  border-top: 1px solid #e5e7eb;
  border-bottom: 1px solid #e5e7eb;

  display: flex;
  flex-direction: column;
  padding: 1rem;

  animation: dropdown 0.2s ease;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
} 

@keyframes dropdown {
  from {
    opacity: 0;
    transform: translateY(-6px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
} 

.mobile-nav-item {
  padding: 12px 10px;
  font-size: 16px;
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


.page-label {
  border: none;
  border-bottom: 1px solid #e5e7eb;
  border-radius: 6px;
  padding: 12px 16px;
  text-align: left;
  font-size: 18px;
  font-weight: 600; 
  letter-spacing: 0.3px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

/* Hide Desktop Nav + Logout on Mobile */
@media (max-width: 768px) {
  .nav-desktop {
    display: none !important;
  }
  .logout-btn {
    display: none;
  }
}


</style>
