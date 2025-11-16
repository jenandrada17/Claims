<template>

  <!-- SEARCH SECTION -->
  <div class="search-section">
    <input
      v-model="searchQuery"
      type="text"
      placeholder="Search patient..."
      class="search-input"
    />
    <button @click="handleSearch" class="search-btn">Search</button>
  </div>

  <!-- PATIENT PROFILE WRAPPER -->
  <div v-if="patient" class="patient-wrapper">

    <!-- TABS -->
    <div class="tabs">
      <button
        v-for="tab in tabs"
        :key="tab"
        @click="activeTab = tab"
        :class="['tab-item', { active: activeTab === tab }]"
      >
        {{ tab }}
      </button>
    </div>

    <!-- GRID LAYOUT -->
    <div class="profile-grid"> 

      <!-- RIGHT COLUMN -->
      <section class="profile-right"> 
        <!-- PERSONAL INFO -->
        <div v-if="activeTab === 'Personal Info'" class="info-list">
          <div class="row">
            <span>RFID</span>
            <strong>{{ patient.rfid }}</strong>
          </div>
          <div class="row">
            <span>Full Name</span>
            <strong>{{ patient.name }}</strong>
          </div>
          <div class="row">
            <span>Address</span>
            <strong>{{ patient.address }}</strong>
          </div>
        </div>

        <!-- CLAIM HISTORY -->
        <div v-if="activeTab === 'Claim History'" class="info-list">
          <div
            v-for="(claim, i) in patient.claimHistory"
            :key="i"
            class="row"
          >
            <span>Claim #{{ i + 1 }}</span>
            <strong>{{ claim }}</strong>
          </div>
        </div>

        <!-- UTILIZATION -->
        <div v-if="activeTab === 'Utilization'" class="info-list">
          <div
            v-for="(utilization, i) in patient.utilization"
            :key="i"
            class="row"
          >
            <span>Claim #1</span>
            <strong>{{ utilization }}</strong>
          </div>
        </div>

      </section>
    </div>

  </div>
</template>

<script>
export default {
  name: "Patient",
  data() {
    return {
      searchQuery: "",
      activeTab: "Personal Info",
      tabs: ["Personal Info", "Claim History", "Utilization"],
      patient: null,
    };
  },
  methods: {
    handleSearch() {
      if (!this.searchQuery.trim()) return alert("Enter a patient name.");

      this.patient = {
        rfid: "02112304559",
        name: "John Doe",
        address: "Purok Sample, Barangay Sample GSC",
        claimHistory: ["Claim #001 - Denge - 12,000","Claim #002 - Pneumonia - 15,000"],
        utilization: ["November 7, 2025 - Dengue - 4,000", "November 20, 2025 - Dengue - 8,000"],
      };
    },
  },
};
</script>

<style scoped> 
/* PAGE SPACING */
.patient-page-wrapper,
:host {
  width: 100%;
  max-width: 1150px;
  margin: auto;
  padding: 20px;
}

/* SEARCH SECTION */
.search-section {
  display: flex;
  gap: 10px;
  margin-bottom: 20px;
}

.search-input {
  flex: 1;
  background-color: white !important;
  color: #374151 !important;         /* gray text */
  padding: 10px 12px;
  border: 1px solid #d1d5db !important;
  border-radius: 6px;
  font-size: 15px;
  outline: none;
  transition: 0.2s;
}

.search-input::placeholder {
  color: #9ca3af; /* light gray placeholder */
}

.search-btn {
  padding: 10px 20px;
  background: #2563eb;
  color: white;
  border-radius: 6px;
  border: none;
}

/* PROFILE CONTAINER */
.patient-wrapper {
  width: 100%;
  max-width: 100%;
  background: white;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);

  padding: 0;          /* ← REMOVE ALL INTERNAL PADDING */
  margin: 0;           /* ← REMOVE OUTER MARGINS */
}


/* TABS */
.tabs {
  display: flex;
  gap: 25px;
  border-bottom: 2px solid #e5e7eb;
  padding: 14px 20px;
}

.tab-item {
  background: none;
  border: none;
  padding: 8px 0;
  color: #6b7280;
  cursor: pointer;
}

.tab-item.active {
  border-bottom: 3px solid #2563eb;
  color: #2563eb;
  font-weight: 600;
}

/* GRID LAYOUT */
.profile-grid {
  width: 100%;           /* make it use the full container width */
  display: grid;
  grid-template-columns: 260px 1fr;
  gap: 20px;
  padding: 20px;
  box-sizing: border-box; /* ensures padding doesn't shrink width */
} 

/* LEFT SIDE */
.profile-left {
  display: flex;
  flex-direction: column;
  gap: 14px;
}

.patient-photo {
  width: 100%;
  border-radius: 8px;
}

.info-box {
  background: #f8fafc;
  padding: 12px;
  border-radius: 8px;
}

.badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 12px;
}

.badge.high { background: #fee2e2; color: #b91c1c; }
.badge.yellow { background: #fef3c7; color: #92400e; }

.btn {
  padding: 10px;
  border-radius: 8px;
  border: none;
  width: 100%;
  cursor: pointer;
}

.action-green { background: #16a34a; color: white; }
.action-yellow { background: #fbbf24; }

/* RIGHT SIDE */
.section-title {
  font-size: 20px;
  font-weight: 600;
}

.section-sub {
  color: #6b7280;
  margin-bottom: 10px;
}

/* INFO LIST */
.info-list {
  background: #f8fafc;
  border-radius: 8px;
}

.row {
  display: grid;
  grid-template-columns: 200px 1fr;
  padding: 12px 16px;
  border-bottom: 1px solid #e5e7eb;
}

.row:last-child {
  border-bottom: none;
}
 
@media (max-width: 900px) {
  .profile-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 600px) {
  .tabs {
    gap: 10px;
    flex-wrap: wrap;
  }

  .row {
    grid-template-columns: 1fr;
  }
}
@media (max-width: 600px) {
  .search-section {
    flex-direction: column;
  }

  .search-btn {
    width: 100%;
  }
} 
</style>
