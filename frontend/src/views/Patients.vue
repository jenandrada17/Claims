<template>

  <!-- SEARCH SECTION -->
  <div class="search-section">
    <div class="search-inner">
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Search patient..."
        class="search-input"
        @keyup.enter="handleSearch"
      />
      <button @click="handleSearch" class="search-btn">Search</button>
    </div>
  </div> 

  <!-- PATIENT PROFILE WRAPPER -->
  <div v-if="patient" class="profile-panel">

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

        <!-- UTILIZATION -->
        <div v-if="activeTab === 'Utilization'" class="info-list">
          <!-- Column headers -->
          <div class="row" style="grid-template-columns: repeat(5, 1fr); background:#e5e7eb;">
            <span><strong>Diagnosis</strong></span>
            <span><strong>Benefit Amount</strong></span>
            <span><strong>Total Deduction</strong></span>
            <span><strong>Remaining Balance</strong></span>
            <span><strong></strong></span>
          </div> 
           
          <!-- Data rows with Show History button -->
          <div
            v-for="(item, i) in patient.utilization"
            :key="i"
            class="row"
            style="grid-template-columns: repeat(5, 1fr); align-items:center;"
          >
            <span>{{ item.diagnosis }}</span>
            <span>{{ item.benefitAmount }}</span>
            <span>{{ item.totalDeduction }}</span>
            <span>{{ item.remainingBalance }}</span>
 
            <span class="history-link" @click="showHistory(item.diagnosis)">
              Show History
            </span> 
          </div>

        </div>

        <!-- CLAIM HISTORY -->  
        <div v-if="activeTab === 'Claim History'" class="info-list">
          <!-- Column headers -->
          <div class="row" style="grid-template-columns: repeat(4, 1fr); background:#e5e7eb;">
            <span><strong>Diagnosis</strong></span>
            <span><strong>Claim Date</strong></span>
            <span><strong>Claim Amount</strong></span> 
          </div>

          <!-- Data rows -->
          <div
            v-for="(item, i) in patient.claimHistory"
            :key="i"
            class="row"
            style="grid-template-columns: repeat(4, 1fr);"
          >
            <span>{{ item.diagnosis }}</span>
            <span>{{ item.claimDate }}</span>
            <span>{{ item.claimAmount }}</span> 
          </div> 

          <!-- Total Row -->
          <div class="row" style="grid-template-columns: repeat(4, 1fr); background:#e0e7ff;">
            <span><strong>Total</strong></span>
            <span></span>
            <span><strong>{{ totalClaimAmount.toLocaleString() }}</strong></span>
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
      tabs: ["Personal Info", "Utilization", "Claim History"],
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
        utilization: [
          {
            diagnosis: "Pneumonia",
            benefitAmount: "50,000",
            totalDeduction: "8,000",
            remainingBalance: "42,000"
          },
          {
            diagnosis: "Dengue",
            benefitAmount: "50,000",
            totalDeduction: "12,000",
            remainingBalance: "38,000"
          }
        ], 
        claimHistory: []
      };
    },  

    showHistory(diagnosis) {
      this.activeTab = "Claim History";

      this.patient.claimHistory = []; 

      // Make sure claimHistory exists
      if (!this.patient.claimHistory) {
        this.patient.claimHistory = [];
      }

      if (diagnosis === "Pneumonia") {
        this.patient.claimHistory.push(
          {
            diagnosis: "Pneumonia",
            claimDate: "November 7, 2025",
            claimAmount: "4,000",
          },
          {
            diagnosis: "Pneumonia",
            claimDate: "November 20, 2025",
            claimAmount: "4,000",
          }
        );
      }

      else if (diagnosis === "Dengue") {
        this.patient.claimHistory.push(
          {
            diagnosis: "Dengue",
            claimDate: "December 1, 2025",
            claimAmount: "8,000",
          },
          {
            diagnosis: "Dengue",
            claimDate: "December 15, 2025",
            claimAmount: "4,000",
          }
        );
      }
    } 
  },

  computed: {
    totalClaimAmount() {
      if (!this.patient || !this.patient.claimHistory) return 0;

      return this.patient.claimHistory.reduce((sum, c) => {
        // remove commas before converting to number
        const amount = Number(c.claimAmount.replace(/,/g, ""));
        return sum + amount;
      }, 0);
    }
  }

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

/* .patient-page-wrapper,
:host {
  width: 100%;
  max-width: 100%;    
  margin: 0;         
  padding: 20px;
} */

.search-section {
  width: 100%;
  display: flex;
  justify-content: center;
  margin: 20px 0;
} 

.search-inner {
  width: 100%;
  max-width: 600px;
  display: flex;
  gap: 10px;
}

.profile-panel {
  width: 100%;
  margin: 0;
  padding: 0;
  background: transparent;
} 

.search-input {
  flex: 1;
  padding: 10px 12px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  background: white;
  color: #374151;
  font-size: 15px;
  width: 100%; 
}

.search-btn {
  padding: 10px 20px;
  background: #2563eb;
  color: white;
  border-radius: 6px;
  border: none;
  font-weight: 600;
  cursor: pointer;
}

.tabs {
  display: flex;
  gap: 25px;
  border-bottom: 2px solid #e5e7eb;
  padding: 14px 20px;
  width: 100%;
  margin-bottom: 30px;
}  

.tab-item {
  flex: 1;
  text-align: center;
  padding: 12px 0;
  background: none;
  border: none;
  cursor: pointer;
  color: #6b7280;
  font-weight: 500;
  border-bottom: 3px solid transparent;
  transition: 0.2s;
}
 
.tab-item.active {
  color: #2563eb;
  border-bottom-color: #2563eb;
}

.profile-grid {
  display: grid;
  grid-template-columns: 1fr;
  width: 100%;
}

/* INFO LIST */
.info-list {
  background: #f8fafc;
  border-radius: 8px;
}

.row {
  display: grid;
  grid-template-columns: 220px 1fr;
  padding: 18px 22px;
  background: #fdfdfd;
  border-bottom: 1px solid #e5e7eb;
  width: 100%;
  font-size: 15px;
  text-align: left;
}  

.row span {
  color: #6b7280;
  font-weight: 500;
}

.row strong {
  font-weight: 600;
  color: #111827;
}

.info-list .row:nth-child(odd) {
  background: #f3f4f6;
}

.history-link {
  color: #2563eb;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  text-decoration: underline;
  text-underline-offset: 3px;
}

.history-link:hover {
  color: #1e4fd1;
} 

@media (max-width: 600px) {
  .row {
    grid-template-columns: 1fr;
  }
  .tabs {
    gap: 10px;
    flex-wrap: wrap;
  }
  .search-inner {
    flex-direction: column;
  }
  .search-btn {
    width: 100%;
  }
}
</style>
