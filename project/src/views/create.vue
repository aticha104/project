
You said:
<template>
  <div class="create-container">
    <!-- Header Section -->
    <header class="create-header">
      <div class="header-content">
        <button @click="goBack" class="btn-back">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
          </svg>
          กลับ
        </button>
        <div class="brand">
          <div class="brand-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
              <line x1="16" y1="2" x2="16" y2="6"></line>
              <line x1="8" y1="2" x2="8" y2="6"></line>
              <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
          </div>
          <h1 class="brand-title">สร้างการประชุม</h1>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="create-main">
      <div class="form-container">
        <div class="form-header">
          <div class="header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
              <circle cx="9" cy="7" r="4"></circle>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
          </div>
          <h2 class="form-title">รายละเอียดการประชุม</h2>
          <p class="form-subtitle">กรุณากรอกข้อมูลการประชุมที่ต้องการสร้าง</p>
        </div>

        <form @submit.prevent="createMeeting" class="meeting-form">
          <!-- Meeting Title -->
          <div class="form-group">
            <label class="form-label">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
              </svg>
              ชื่อการประชุม
            </label>
            <input
              type="text"
              v-model="meeting_title"
              class="form-input"
              placeholder="กรอกชื่อการประชุม"
              required
            />
          </div>

          <!-- Meeting Date -->
          <div class="form-group">
            <label class="form-label">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
              </svg>
              วันที่ประชุม
            </label>
            <input
              type="date"
              v-model="meeting_date"
              class="form-input"
              required
            />
          </div>

          <!-- Meeting Time -->
<div class="form-group">
  <label class="form-label">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="12" cy="12" r="10"></circle>
      <polyline points="12 6 12 12 16 14"></polyline>
    </svg>
    เวลาประชุม
  </label>

  <div style="display: flex; gap: 12px;">
    <!-- เวลาเริ่ม -->
    <div style="flex: 1;">
      <small>เริ่ม</small>
      <input
        type="time"
        v-model="meeting_time"
        class="form-input"
        required
      />
    </div>

    <!-- เวลาสิ้นสุด -->
    <div style="flex: 1;">
      <small>เสร็จสิ้น</small>
      <input
        type="time"
        v-model="meeting_time_end"
        class="form-input"
        required
      />
    </div>
  </div>
</div>

<div class="form-group">
            <label class="form-label">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                <circle cx="12" cy="10" r="3"></circle>
              </svg>
              สถานที่การประชุม
            </label>
            <input
              type="text"
              v-model="meeting_at"
              class="form-input"
              placeholder="กรอกห้องประชุม หรือ สถานที่"
              required
            />
          </div>

<!-- ผู้เข้าร่วม -->
<div class="form-group selection-section">
  <label class="form-label">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
      <circle cx="9" cy="7" r="4"></circle>
    </svg>
    ผู้เข้าร่วมประชุม
  </label>
  <input type="text" v-model="searchParticipants" class="form-input search-input" placeholder="🔍 ค้นหารายชื่อประชุม..." style="margin-bottom: 12px; border-color: #556b2f;" />
  <div class="people-list-container">
    <div 
      v-for="person in filteredParticipants" 
      :key="'part-'+person.id"
      :class="['person-chip', { 'selected': isSelected(person, 'selectedParticipants') }]"
      @click="toggleSelection(person, 'selectedParticipants', 'selectedAbsentees')"
    >
      <div class="person-info">
  <span class="person-name">{{ person.name }}</span>

  <!-- เลือกบทบาท -->
  <select
    v-model="person.role_id"
    class="mini-select"
    @click.stop
  >
    <option
      v-for="role in roles"
      :key="role.id"
      :value="role.id"
    >
      {{ role.name }}
    </option>
  </select>
</div>

      <div class="check-icon" v-if="isSelected(person, 'selectedParticipants')">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
      </div>
    </div>
  </div>
</div>

<!-- ผู้ไม่เข้าร่วม -->
<div class="form-group selection-section">
  <label class="form-label">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
      <circle cx="9" cy="7" r="4"></circle>
    </svg>
    ผู้ไม่เข้าร่วมประชุม
  </label>
  <input type="text" v-model="searchAbsentees" class="form-input search-input" placeholder="🔍 ค้นหารายชื่อเพื่อระบุคนไม่มา..." style="margin-bottom: 12px; border-color: #556b2f;" />
  <div class="people-list-container">
    <div 
      v-for="person in filteredAbsentees" 
      :key="'abs-'+person.id"
      :class="['person-chip absentee-chip', { 'selected': isSelected(person, 'selectedAbsentees') }]"
      @click="toggleSelection(person, 'selectedAbsentees', 'selectedParticipants')"
    >
      <div class="person-info">
  <span class="person-name">{{ person.name }}</span>

  <!-- เลือกบทบาท -->
  <select
    v-model="person.role_id"
    class="mini-select"
    @click.stop
  >
    <option
      v-for="role in roles"
      :key="role.id"
      :value="role.id"
    >
      {{ role.name }}
    </option>
  </select>
</div>

      <div class="check-icon" v-if="isSelected(person, 'selectedAbsentees')">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
      </div>
    </div>
  </div>
</div>
          <!-- Action Buttons -->
          <div class="form-actions">
            <button type="button" @click="goBack" class="btn-cancel">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
              ยกเลิก
            </button>
            <button type="submit" class="btn-submit" :disabled="loading">
              <svg v-if="!loading" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
              </svg>
              <svg v-else class="spinner" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="2" x2="12" y2="6"></line>
                <line x1="12" y1="18" x2="12" y2="22"></line>
                <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
                <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
                <line x1="2" y1="12" x2="6" y2="12"></line>
                <line x1="18" y1="12" x2="22" y2="12"></line>
                <line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>
                <line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
              </svg>
              {{ loading ? "กำลังบันทึก..." : "บันทึก" }}
            </button>
          </div>
        </form>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  name: "CreateMeeting",

  data() {
    return {
      meeting_title: "",
      meeting_date: "",
      meeting_time: "",
      meeting_time_end: "",
      meeting_at: "",
      loading: false,

      allPeople: [],

      roles: [
        { id: 1, name: "ประธานกรรมการ" },
        { id: 2, name: "ผู้ช่วยเลขานุการและกรรมการ" },
        { id: 3, name: "เลขานุการ" },
        { id: 4, name: "กรรมการ" },
        { id: 5, name: "ติดราชการ" }
      ],

      selectedParticipants: [],
      selectedAbsentees: [],
      searchParticipants: "",
      searchAbsentees: ""
    };
  },

  computed: {
    filteredParticipants() {
      let list = this.allPeople;

      if (this.searchParticipants) {
        const s = this.searchParticipants.toLowerCase();
        list = list.filter(p =>
          (p.name || "").toLowerCase().includes(s)
        );
      } else {
        list = list.slice(0, 50);
      }

      return list;
    },

    filteredAbsentees() {
      let list = this.allPeople.filter(
        p => !this.selectedParticipants.some(part => part.id === p.id)
      );

      if (this.searchAbsentees) {
        const s = this.searchAbsentees.toLowerCase();
        list = list.filter(p =>
          (p.name || "").toLowerCase().includes(s)
        );
      } else {
        list = list.slice(0, 50);
      }

      return list;
    }
  },

  watch: {
    selectedParticipants: {
      handler() {
        this.saveSelection();
      },
      deep: true
    },
    selectedAbsentees: {
      handler() {
        this.saveSelection();
      },
      deep: true
    }
  },

  methods: {
    goBack() {
      this.$router.push("/dashboard");
    },

    async fetchPeople() {
      try {
        const payload = { fnc: "find_user_all" };

        const res = await fetch("http://192.168.4.246/api/gtw/users/", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(payload)
        });

        const rawData = await res.json();

        if (rawData.status !== 1) return;

        if (Array.isArray(rawData.data)) {
          this.allPeople = rawData.data.map((item, index) => ({
            id: item.ID || `p-${index}`,
            name:
              ((item.HR_PREFIX_NAME || "") + " " +
               (item.HR_FNAME || "") + " " +
               (item.HR_LNAME || "")+" "+
               (item.POSITION_LEVEL || "")) ||
              "ไม่ทราบชื่อ",
            role_id: 5 // default = ติดราชการ
          }));
        }

      } catch (err) {
        console.error("โหลดรายชื่อไม่สำเร็จ:", err);
      }
    },

    saveSelection() {
      const data = {
        selectedParticipants: this.selectedParticipants.map(p => ({
          id: p.id,
          role_id: p.role_id
        })),
        selectedAbsentees: this.selectedAbsentees.map(p => ({
          id: p.id,
          role_id: p.role_id
        }))
      };

      localStorage.setItem("meetingSelection_draft", JSON.stringify(data));
    },

    toggleSelection(person, currentListKey, otherListKey) {
      const currentList = this[currentListKey];
      const otherList = this[otherListKey];

      const index = currentList.findIndex(p => p.id === person.id);

      if (index > -1) {
        currentList.splice(index, 1);
      } else {
        currentList.push(person);

        const otherIndex = otherList.findIndex(p => p.id === person.id);
        if (otherIndex > -1) otherList.splice(otherIndex, 1);
      }
    },

    isSelected(person, listKey) {
      return this[listKey].some(p => p.id === person.id);
    },

    async createMeeting() {
      if (this.loading || !this.meeting_title) return;
      this.loading = true;

      try {
        const payload = {
          meeting_title: this.meeting_title,
          meeting_date: this.meeting_date,
          meeting_time: this.meeting_time,
          meeting_time_end: this.meeting_time_end,
          meeting_at: this.meeting_at,
          participants: this.selectedParticipants,
          absentees: this.selectedAbsentees
        };

        const res = await fetch("http://localhost/project/backend/create.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(payload)
        });

        const text = await res.text();
        console.log("SERVER RESPONSE:", text);

        if (!res.ok) {
      throw new Error(text);
    }

    const result = JSON.parse(text);

        if (result.success) {
          alert("สร้างการประชุมสำเร็จ");
          this.$router.push(`/meeting/${result.meeting_id}/agendas/create`);
        } else {
          alert(result.message || "เกิดข้อผิดพลาด");
        }

      } catch (err) {
        console.error("CREATE ERROR:", err);
        alert("เชื่อมต่อเซิร์ฟเวอร์ไม่ได้");
      } finally {
        this.loading = false;
      }
    }
  },

  mounted() {
    this.fetchPeople();
  }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

.create-container {
  min-height: 100vh;
  background: #fdfcf8; /* Soft cream */
  position: relative;
}

/* Header */
.create-header {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(20px);
  box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
  position: sticky;
  top: 0;
  z-index: 1000;
}

.header-content {
  max-width: 1000px;
  margin: 0 auto;
  padding: 20px 40px;
  display: flex;
  align-items: center;
  gap: 24px;
}

.btn-back {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 10px 20px;
  background: rgba(85, 107, 47, 0.1);
  color: #556b2f; /* Dark Olive Green */
  border: 2px solid #556b2f;
  border-radius: 12px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-back:hover {
  background: #556b2f;
  color: white;
  transform: translateX(-3px);
}

.brand {
  display: flex;
  align-items: center;
  gap: 14px;
  flex: 1;
}

.brand-icon {
  width: 48px;
  height: 48px;
  background: linear-gradient(135deg, #556b2f 0%, #8fbc8f 100%); /* Olive to Sea Green */
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 6px 20px rgba(85, 107, 47, 0.4);
}

.brand-icon svg {
  color: white;
}

.brand-title {
  font-size: 26px;
  font-weight: 800;
  background: none;
  color: #2f4f4f; /* Dark Slate Gray */
  -webkit-text-fill-color: initial;
}

/* Main Content */
.create-main {
  max-width: 1000px;
  margin: 0 auto;
  padding: 40px;
}

.form-container {
  background: white;
  border-radius: 28px;
  padding: 48px;
  box-shadow: 0 20px 60px rgba(85, 107, 47, 0.1);
}

.form-header {
  margin-bottom: 40px;
  text-align: center;
}

.header-icon {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 24px;
  box-shadow: 0 12px 40px rgba(102, 126, 234, 0.4);
  animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
  0%, 100% {
    transform: scale(1);
    box-shadow: 0 12px 40px rgba(102, 126, 234, 0.4);
  }
  50% {
    transform: scale(1.05);
    box-shadow: 0 16px 50px rgba(102, 126, 234, 0.5);
  }
}

.header-icon svg {
  color: white;
}

.form-title {
  font-size: 32px;
  font-weight: 800;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 12px;
}

.form-subtitle {
  font-size: 16px;
  color: #64748b;
  font-weight: 500;
}

/* Form */
.meeting-form {
  display: flex;
  flex-direction: column;
  gap: 28px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.form-label {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 15px;
  font-weight: 600;
  color: #1a202c;
}

.form-label svg {
  color: #667eea;
}

.form-input {
  width: 100%;
  padding: 16px 20px;
  border: 2px solid #e2e8f0;
  border-radius: 14px;
  font-size: 15px;
  font-weight: 500;
  color: #1a202c;
  background: #f8fafc;
  transition: all 0.3s ease;
}

.form-input:focus {
  outline: none;
  border-color: #556b2f;
  background: white;
  box-shadow: 0 4px 20px rgba(85, 107, 47, 0.15);
}

.search-input {
  background: #fdfcf8 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23556b2f' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'%3E%3C/circle%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'%3E%3C/line%3E%3C/svg%3E") no-repeat 16px center;
  padding-left: 45px !important;
  font-size: 14px;
}

.form-input::placeholder {
  color: #94a3b8;
}

/* Form Actions */
.form-actions {
  display: flex;
  gap: 16px;
  margin-top: 20px;
}

.btn-cancel,
.btn-submit {
  flex: 1;
  padding: 16px 32px;
  border: none;
  border-radius: 14px;
  font-size: 16px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
}

.btn-cancel {
  background: #f1f5f9;
  color: #475569;
  border: 2px solid #e2e8f0;
}

.btn-cancel:hover {
  background: #e2e8f0;
  transform: translateY(-2px);
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.btn-submit {
  background: linear-gradient(135deg, #556b2f 0%, #228b22 100%); /* Forest Green */
  color: white;
  box-shadow: 0 8px 24px rgba(34, 139, 34, 0.3);
}

.btn-submit:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 36px rgba(34, 139, 34, 0.4);
}

.btn-submit:active {
  transform: translateY(-1px);
}

.btn-submit:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.btn-submit:disabled:hover {
  transform: none;
  box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
}

.spinner {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

/* Responsive */
@media (max-width: 768px) {
  .create-main {
    padding: 24px;
  }
  
  .header-content {
    padding: 16px 24px;
  }
  
  .form-container {
    padding: 32px 24px;
  }
  
  .form-title {
    font-size: 26px;
  }
  
  .form-actions {
    flex-direction: column;
  }
}

/* Selection Styles */
.selection-section {
  margin-top: 10px;
}

.people-list-container {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-top: 12px;
  max-height: 300px;
  overflow-y: auto;
  padding-right: 8px;
  border: 1px solid #f1f5f9;
  border-radius: 12px;
  padding: 12px;
  background: #fdfdfd;
}

/* Scrollbar styling */
.people-list-container::-webkit-scrollbar {
  width: 6px;
}
.people-list-container::-webkit-scrollbar-track {
  background: #f1f5f9;
}
.people-list-container::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 10px;
}

.person-chip {
  background: white;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  padding: 10px 16px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  transition: all 0.2s;
  cursor: pointer;
}

.person-chip:hover {
  border-color: #667eea;
  background: #f8fafc;
}

.person-chip.selected {
  background: #eef2ff;
  border-left: 4px solid #6366f1;
  border-color: #6366f1;
}

.absentee-chip.selected {
  background: #fef2f2;
  border-left: 4px solid #ef4444;
  border-color: #ef4444;
}

.person-info {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
}

.person-name {
  font-size: 15px;
  font-weight: 500;
  color: #1e293b;
}

.person-position {
  font-size: 13px;
  color: #64748b;
  background: #f1f5f9;
  padding: 2px 8px;
  border-radius: 6px;
}

.selected .person-position {
  background: white;
  color: #6366f1;
}

.absentee-chip.selected .person-position {
  background: white;
  color: #ef4444;
}

.check-icon {
  width: 22px;
  height: 22px;
  background: #6366f1;
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  box-shadow: 0 2px 5px rgba(99, 102, 241, 0.3);
}

.absentee-chip.selected .check-icon {
  background: #ef4444;
  box-shadow: 0 2px 5px rgba(239, 68, 68, 0.3);
}

.mini-select {
  font-size: 12px;
  padding: 4px 6px;
  border-radius: 6px;
  border: 1px solid #cbd5e1;
  background: #f8fafc;
  cursor: pointer;
}


</style>