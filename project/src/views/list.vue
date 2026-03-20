<template>
  <div class="list-container">
    <!-- Header Section -->
    <header class="list-header">
      <div class="header-content">
        <button @click="goBack" class="btn-back">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 12H5"></path>
            <polyline points="12 19 5 12 12 5"></polyline>
          </svg>
          กลับหน้าหลัก
        </button>
        <div class="header-title">
          <div class="icon-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
              <polyline points="14 2 14 8 20 8"></polyline>
              <line x1="16" y1="13" x2="8" y2="13"></line>
              <line x1="16" y1="17" x2="8" y2="17"></line>
              <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
          </div>
          <h1>รายการทั้งหมด</h1>
        </div>
      </div>
    </header>

    <!-- Content Section -->
    <main class="list-content">
      <div class="content-card">
        <div v-if="loading" class="loading-state">
          <div class="spinner"></div>
          <p>กำลังโหลดข้อมูล...</p>
        </div>

        <div v-else-if="error" class="error-state">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
          </svg>
          <p>{{ error }}</p>
          <button @click="fetchData" class="btn-retry">ลองใหม่</button>
        </div>

        <div v-else-if="items.length === 0" class="empty-state">
          <p>ไม่พบข้อมูล</p>
        </div>

        <div v-else class="table-responsive">
          <table class="data-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>หัวข้อ</th>
                <th>วันที่</th>
                <th>เวลา</th>
                <th>สร้างเมื่อ</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in items" :key="item.meeting_id" class="clickable-row">
                <td @click="$router.push(`/meeting/${item.meeting_id}/agendas/create`)">#{{ item.meeting_id }}</td>
                <td @click="$router.push(`/meeting/${item.meeting_id}/agendas/create`)" class="primary-text">{{ item.meeting_title }}</td>
                <td @click="$router.push(`/meeting/${item.meeting_id}/agendas/create`)">{{ formatDate(item.meeting_date) }}</td>
                <td @click="$router.push(`/meeting/${item.meeting_id}/agendas/create`)">{{ formatTime(item.meeting_time) }}</td>
                <td @click="$router.push(`/meeting/${item.meeting_id}/agendas/create`)" class="secondary-text">{{ formatDateTime(item.created_at) }}</td>
                <td class="text-center">
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  name: "ListView",

  data() {
    return {
      items: [],
      loading: true,
      error: null
    };
  },

  mounted() {
    this.fetchData();
  },

  methods: {

    goBack() {
      this.$router.push("/dashboard");
    },

    async fetchData() {
      this.loading = true;
      this.error = null;

      try {
        const response = await fetch("http://localhost/project/backend/list.php");

        if (!response.ok) {
          throw new Error("Network response was not ok");
        }

        const result = await response.json();

        if (result.success !== false) {
          this.items = result.data || result;
        } else {
          throw new Error(result.message || "โหลดข้อมูลไม่สำเร็จ");
        }

      } catch (err) {
        console.error(err);
        this.error = err.message;
      } finally {
        this.loading = false;
      }
    },

    goCreateAgenda(meeting) {
        this.$router.push(`/createAgendas/${meeting.meeting_id}`);
},

    formatDate(dateStr) {
      if (!dateStr) return "-";
      return new Date(dateStr).toLocaleDateString("th-TH");
    },

    formatTime(timeStr) {
      if (!timeStr) return "-";
      return timeStr.substring(0,5);
    },

    formatDateTime(dateTimeStr) {
      if (!dateTimeStr) return "-";
      return new Date(dateTimeStr).toLocaleString("th-TH");
    }

  }
};
</script>

<style scoped>
.list-container {
  min-height: 100vh;
  background-color: #fdfcf8; 
  font-family: 'Inter', sans-serif;
}

.list-header {
  background: white;
  padding: 20px 30px;
  box-shadow: 0 4px 6px -1px rgba(85, 107, 47, 0.05);
  position: sticky;
  top: 0;
  z-index: 10;
}

.header-content {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.btn-back {
  align-self: flex-start;
  display: flex;
  align-items: center;
  gap: 8px;
  background: none;
  border: none;
  color: #6b8e23; 
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  padding: 8px 0;
  transition: color 0.2s;
}

.btn-back:hover {
  color: #228b22; 
}

.header-title {
  display: flex;
  align-items: center;
  gap: 15px;
}

.icon-wrapper {
  width: 40px;
  height: 40px;
  background: linear-gradient(135deg, #8fbc8f 0%, #2e8b57 100%);    
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  box-shadow: 0 4px 12px rgba(46, 139, 87, 0.2);
}

.header-title h1 {
  font-size: 24px;
  font-weight: 700;
  color: #2f4f4f; 
  margin: 0;
}

.list-content {
  max-width: 1200px;
  margin: 30px auto;
  padding: 0 20px;
}

.content-card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 6px -1px rgba(85, 107, 47, 0.05);
  padding: 30px;
  min-height: 400px;
}

.loading-state, .error-state, .empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 300px;
  color: #64748b;
  gap: 15px;
}

.spinner {
  width: 40px;
  height: 40px;
  border: 3px solid #e2e8f0;
  border-top-color: #556b2f; 
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.btn-retry {
  padding: 8px 20px;
  background: #556b2f;  
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
}

.table-responsive {
  overflow-x: auto;
}

.data-table {
  width: 100%;
  border-collapse: collapse;
  min-width: 800px;
}

.data-table th, .data-table td {
  padding: 16px;
  text-align: left;
  border-bottom: 1px solid #e2e8f0;
}

.data-table th {
  background-color: #f7f9f0; 
  font-weight: 600;
  color: #556b2f; 
  font-size: 14px;
}

.text-center {
  text-align: center;
}

.btn-delete {
  background: none;
  border: none;
  color: #ef4444;
  cursor: pointer;
  padding: 8px;
  border-radius: 8px;
  transition: all 0.2s;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.btn-delete:hover {
  background-color: #fef2f2;
  color: #dc2626;
  transform: scale(1.1);
}

.data-table td {
  color: #334155;
  font-size: 15px;
}

.data-table tr:hover {
  background-color: #f0fff0; 
}

.clickable-row {
  cursor: pointer;
  transition: background-color 0.2s;
}

.clickable-row:hover {
  background-color: #f0fff0;
}

.primary-text {
  font-weight: 600;
  color: #2f4f4f;
}

.secondary-text {
  color: #64748b;
  font-size: 14px;
}

@media (max-width: 640px) {
  .header-content {
    flex-direction: column;
    gap: 10px;
  }
  
  .list-content {
    padding: 0 15px;
  }
  
  .content-card {
    padding: 15px;
  }
}
</style>
