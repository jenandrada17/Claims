<template>
  <div class="p-4 space-y-4">
 
    <div class="top-bar">
      <button @click="goToAddNew" class="add-btn">Add New</button> 
 
      <div class="search-inner">
        <input
        v-model="search"
        type="text"
        placeholder="Search claims..."
        class="search-input"
        @keyup.enter="handleSearch"
        />

        <button @click="handleSearch" class="search-btn">Search</button>
      </div>
    </div> 
 
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
      <div>
        <label class="block text-sm font-medium">Date Issued (From)</label>
        <input type="date" v-model="dateFrom" class="filter-input" />
      </div> 

      <div>
        <label class="block text-sm font-medium">Date Issued (To)</label>
        <input type="date" v-model="dateTo" class="filter-input" />
      </div> 

      <div>
        <button @click="clearFilters" class="clear-btn">Clear Filters</button>
      </div>
    </div>
 
    <table class="w-full border rounded-lg overflow-hidden">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 text-left">Claim #</th>
          <th class="px-4 py-2 text-left">Name</th>
          <th class="px-4 py-2 text-left">Date Issued</th>
          <th class="px-4 py-2 text-left">Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="claim in filteredClaims" :key="claim.id" class="border-t">
          <td class="px-4 py-2">{{ claim.claimNumber }}</td>
          <td class="px-4 py-2">{{ claim.name }}</td>
          <td class="px-4 py-2">{{ claim.dateIssued }}</td>
          <td class="px-4 py-2">{{ claim.status }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'Claims',
  data() {
    return {
      search: '',
      dateFrom: '',
      dateTo: '',
      claims: [ 
        { id: 1, claimNumber: 'CL-001', name: 'John Doe', dateIssued: '2025-01-10', status: 'Pending' },
        { id: 2, claimNumber: 'CL-002', name: 'Jane Smith', dateIssued: '2025-01-15', status: 'Approved' },
      ]
    }
  },
  computed: {
    filteredClaims() {
      return this.claims.filter(c => {
        const matchesSearch = this.search === '' ||
          c.claimNumber.toLowerCase().includes(this.search.toLowerCase()) ||
          c.name.toLowerCase().includes(this.search.toLowerCase())

        const issued = new Date(c.dateIssued)
        const from = this.dateFrom ? new Date(this.dateFrom) : null
        const to = this.dateTo ? new Date(this.dateTo) : null

        const matchesFrom = !from || issued >= from
        const matchesTo = !to || issued <= to

        return matchesSearch && matchesFrom && matchesTo
      })
    }
  },
  methods: {
    goToAddNew() {
      this.$router.push('/claims/new')
    },
    clearFilters() {
      this.search = ''
      this.dateFrom = ''
      this.dateTo = ''
    }
  }
}
</script>

<style scoped> 
.claims-wrapper,
:host {
  width: 100%;
  max-width: 1150px;
  margin: auto;
  padding: 20px;
}
 
.search-inner {
display: flex;
align-items: center;
gap: 12px;
}
 
.search-btn {
padding: 10px 22px;
background: #2563eb;
color: white;
border-radius: 6px;
border: none;
font-weight: 600;
cursor: pointer;
transition: background 0.2s;
}
 
.search-input {
background: white !important;
color: #111827;
border: 1px solid #d1d5db;
border-radius: 6px;
padding: 10px 12px;
}
 
.top-bar {
display: flex;
justify-content: space-between;
align-items: center;
width: 100%;
gap: 20px;
flex-wrap: nowrap;
}
 
.filter-section {
  width: 100%;
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin-bottom: 25px;
  align-items: flex-end;
}

.filter-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
  flex: 1;
  min-width: 200px;
}

.filter-label {
  font-size: 14px;
  color: #6b7280;
  font-weight: 500;
}

.filter-input {
  padding: 10px 12px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  background: white;
  color: #374151;
  font-size: 15px;
}

.filter-input:focus {
  outline: none;
  border-color: #2563eb;
}

.clear-btn,
.add-btn {
  padding: 10px 20px;
  border-radius: 6px;
  border: none;
  cursor: pointer;
  font-weight: 600;
  transition: 0.2s;
}

.clear-btn {
  background: #e5e7eb;
  color: #374151;
}

.clear-btn:hover {
  background: #d1d5db;
}

.add-btn {
  background: #2563eb;
  color: white;
}

.add-btn:hover {
  background: #1e4fd1;
}
 
.table-wrapper {
  width: 100%;
  overflow-x: auto;
  background: white;
  border-radius: 8px;
  border: 1px solid #e5e7eb;
}

table {
  width: 100%;
  border-collapse: collapse;
}

thead tr {
  background: #f3f4f6;
}

th {
  padding: 14px 18px;
  font-size: 15px;
  text-align: left;
  color: #374151;
  font-weight: 600;
  border-bottom: 1px solid #e5e7eb;
}

td {
  padding: 14px 18px;
  font-size: 15px;
  border-bottom: 1px solid #e5e7eb;
  color: #111827;
}

tbody tr:nth-child(odd) {
  background: #f9fafb;
}

tbody tr:hover {
  background: #eef2ff;
}
 
@media (max-width: 800px) {
  .filter-section {
    flex-direction: column;
    gap: 15px;
  }
  .filter-group {
    width: 100%;
  }
  .add-btn,
  .clear-btn {
    width: 100%;
  }
  th, td {
    padding: 12px;
    font-size: 14px;
  }
}

@media (max-width: 500px) {
  .table-wrapper {
    border-radius: 4px;
  }
  table {
    font-size: 14px;
  }
  thead tr {
    font-size: 13px;
  }
  td {
    word-break: break-word;
  }

.add-btn,
  .clear-btn {
    width: 100%;
  }
  th,
  td {
    padding: 12px;
  }
}
</style>
