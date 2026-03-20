<template>
  <div class="dashboard-page">

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar">
      <div class="nav-inner">
        <div class="brand">
          <div class="brand-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
            </svg>
          </div>
          <span class="brand-name">Hatyai Hospital</span>
        </div>

        <div class="nav-right">
          <div class="user-pill">
            <div class="user-avatar">{{ user?.uname?.charAt(0)?.toUpperCase() || 'U' }}</div>
            <span class="user-name">{{ user?.fnc || 'User' }}</span>
          </div>
          <button @click="logout" class="logout-btn" title="ออกจากระบบ">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
              <polyline points="16 17 21 12 16 7"/>
              <line x1="21" y1="12" x2="9" y2="12"/>
            </svg>
          </button>
        </div>
      </div>
    </nav>

    <!-- ===== HERO BANNER ===== -->
    <div class="hero-banner">
      <div class="hero-inner">
        <div class="hero-text">
          <p class="hero-greeting">สวัสดี, {{ user?.fnc }} 👋</p>
          <h1 class="hero-title">ระบบจัดการการประชุม</h1>
          <p class="hero-sub">โรงพยาบาลหาดใหญ่ · Hatyai Hospital</p>
        </div>
        <div class="hero-deco">
          <div class="deco-circle c1"></div>
          <div class="deco-circle c2"></div>
          <div class="deco-circle c3"></div>
          <svg class="deco-doc" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 100" fill="none">
            <rect x="5" y="5" width="70" height="90" rx="8" fill="rgba(255,255,255,0.15)" stroke="rgba(255,255,255,0.3)" stroke-width="2"/>
            <line x1="20" y1="30" x2="60" y2="30" stroke="rgba(255,255,255,0.5)" stroke-width="3" stroke-linecap="round"/>
            <line x1="20" y1="45" x2="60" y2="45" stroke="rgba(255,255,255,0.4)" stroke-width="3" stroke-linecap="round"/>
            <line x1="20" y1="60" x2="45" y2="60" stroke="rgba(255,255,255,0.3)" stroke-width="3" stroke-linecap="round"/>
          </svg>
        </div>
      </div>
    </div>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="main-content">

      <!-- Quick Actions -->
      <div class="quick-actions">
        <div class="qa-card primary" @click="create">
          <div class="qa-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="4" width="18" height="18" rx="2"/>
              <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
              <line x1="3" y1="10" x2="21" y2="10"/>
              <line x1="12" y1="14" x2="12" y2="18"/><line x1="10" y1="16" x2="14" y2="16"/>
            </svg>
          </div>
          <div class="qa-body">
            <h3>สร้างการประชุมใหม่</h3>
            <p>นัดหมายและกำหนดวาระการประชุม</p>
          </div>
          <div class="qa-arrow">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </div>
        </div>

        <div class="qa-card secondary" @click="$router.push('/list')">
          <div class="qa-icon secondary-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
              <polyline points="14 2 14 8 20 8"/>
              <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
          </div>
          <div class="qa-body">
            <h3>รายการทั้งหมด</h3>
            <p>ดูประวัติการประชุมทั้งหมด</p>
          </div>
          <div class="qa-arrow">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </div>
        </div>
      </div>

      <!-- Recent Meetings -->
      <section class="recent-section">
        <div class="section-head">
          <div class="section-title">
            <div class="section-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <h2>การประชุมล่าสุด</h2>
          </div>
          <button class="see-all-btn" @click="$router.push('/list')">ดูทั้งหมด →</button>
        </div>

        <!-- Loading -->
        <div v-if="loadingItems" class="state-box">
          <div class="spinner"></div>
          <p>กำลังโหลดข้อมูล...</p>
        </div>

        <!-- Empty -->
        <div v-else-if="recentItems.length === 0" class="state-box empty">
          <div class="empty-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
          </div>
          <p>ยังไม่มีการประชุม</p>
          <button @click="create" class="btn-create-now">+ สร้างการประชุมแรก</button>
        </div>

        <!-- List -->
        <div v-else class="meeting-list">
          <div
            v-for="item in recentItems"
            :key="item.meeting_id"
            class="meeting-card"
            @click="goToAgendas(item.meeting_id)"
          >
            <!-- Date Badge -->
            <div class="date-badge">
              <span class="date-day">{{ getDay(item.meeting_date) }}</span>
              <span class="date-month">{{ getMonth(item.meeting_date) }}</span>
            </div>

            <!-- Info -->
            <div class="meeting-info">
              <h4 class="meeting-name">{{ item.meeting_title }}</h4>
              <div class="meeting-meta">
                <span class="meta-tag">
                  <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                  {{ formatTime(item.meeting_time) }}<template v-if="item.meeting_time_end"> – {{ formatTime(item.meeting_time_end) }}</template>
                </span>
                <span v-if="item.meeting_at" class="meta-tag">
                  <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                  {{ item.meeting_at }}
                </span>
              </div>
            </div>

            <!-- Edit Icon -->
            <div class="edit-btn">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </div>
          </div>
        </div>
      </section>

    </main>
  </div>
</template>

<script>
export default {
  name: "Dashboard",
  data() {
    return {
      user: null,
      recentItems: [],
      loadingItems: true
    };
  },
  mounted() {
    const userData = localStorage.getItem("user");
    if (!userData) {
      this.$router.push("/login");
      return;
    }
    try {
      this.user = JSON.parse(userData);
    } catch {
      this.user = { uname: userData };
    }
    this.fetchRecentItems();
  },
  methods: {
    logout() {
      if (confirm("ต้องการออกจากระบบใช่หรือไม่?")) {
        localStorage.removeItem("user");
        this.$router.push("/login");
      }
    },
    create() {
      this.$router.push("/create-meeting");
    },
    goToAgendas(meetingId) {
      this.$router.push({ name: "CreateAgendas", params: { id: meetingId } });
    },
    async fetchRecentItems() {
      this.loadingItems = true;
      try {
        const res = await fetch("http://localhost/project/backend/list.php?limit=5");
        const result = await res.json();
        if (result.success !== false) {
          this.recentItems = Array.isArray(result) ? result : (result.data || []);
        }
      } catch (err) {
        console.error("Error fetching recent items:", err);
      } finally {
        this.loadingItems = false;
      }
    },
    getDay(dateStr) {
      if (!dateStr) return "-";
      return new Date(dateStr).getDate();
    },
    getMonth(dateStr) {
      if (!dateStr) return "-";
      return new Date(dateStr).toLocaleDateString("th-TH", { month: "short" });
    },
    formatTime(timeStr) {
      if (!timeStr) return "";
      return timeStr.substring(0, 5) + " น.";
    }
  }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=Bai+Jamjuree:wght@400;500;600;700;800&display=swap');

/* ===== BASE ===== */
.dashboard-page {
  min-height: 100vh;
  background: #fdfcf8;
  font-family: 'Sarabun', sans-serif;
  color: #2f4f4f;
}

/* ===== NAVBAR ===== */
.navbar {
  background: rgba(255,255,255,0.9);
  backdrop-filter: blur(16px);
  border-bottom: 1px solid rgba(85,107,47,0.1);
  position: sticky;
  top: 0;
  z-index: 200;
  box-shadow: 0 2px 12px rgba(0,0,0,0.04);
}
.nav-inner {
  max-width: 1100px;
  margin: 0 auto;
  padding: 14px 32px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.brand { display: flex; align-items: center; gap: 12px; }
.brand-icon {
  width: 40px; height: 40px;
  background: linear-gradient(135deg, #556b2f, #8fbc8f);
  border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  color: white;
  box-shadow: 0 4px 12px rgba(85,107,47,0.25);
}
.brand-name {
  font-family: 'Bai Jamjuree', sans-serif;
  font-size: 18px; font-weight: 700; color: #2f4f4f;
}
.nav-right { display: flex; align-items: center; gap: 14px; }
.user-pill {
  display: flex; align-items: center; gap: 10px;
  background: white;
  padding: 6px 16px 6px 6px;
  border-radius: 50px;
  border: 1.5px solid #e8f0e0;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.user-avatar {
  width: 34px; height: 34px;
  background: linear-gradient(135deg, #556b2f, #2e8b57);
  color: white; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-weight: 700; font-size: 15px;
  box-shadow: 0 2px 8px rgba(85,107,47,0.3);
}
.user-name { font-size: 14px; font-weight: 600; color: #4a5568; }
.logout-btn {
  width: 40px; height: 40px;
  border-radius: 12px; border: none;
  background: #fff5f5; color: #e53e3e;
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  transition: all 0.25s;
}
.logout-btn:hover { background: #e53e3e; color: white; transform: scale(1.05); }

/* ===== HERO BANNER ===== */
.hero-banner {
  background: linear-gradient(135deg, #3d5a1e 0%, #556b2f 40%, #2e8b57 100%);
  position: relative;
  overflow: hidden;
  padding: 0;
}
.hero-inner {
  max-width: 1100px;
  margin: 0 auto;
  padding: 56px 32px 60px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: relative;
  z-index: 2;
}
.hero-greeting {
  font-size: 16px; color: rgba(255,255,255,0.75);
  margin-bottom: 10px; font-weight: 500;
}
.hero-title {
  font-family: 'Bai Jamjuree', sans-serif;
  font-size: 36px; font-weight: 800;
  color: white;
  margin-bottom: 10px;
  text-shadow: 0 2px 12px rgba(0,0,0,0.15);
}
.hero-sub { font-size: 15px; color: rgba(255,255,255,0.65); }

/* Decorative circles */
.hero-deco { position: relative; width: 180px; height: 180px; flex-shrink: 0; }
.deco-circle {
  position: absolute; border-radius: 50%;
  background: rgba(255,255,255,0.08);
  border: 1.5px solid rgba(255,255,255,0.15);
  animation: float 6s ease-in-out infinite;
}
.c1 { width: 120px; height: 120px; top: 10px; left: 10px; animation-delay: 0s; }
.c2 { width: 80px; height: 80px; top: 60px; left: 70px; animation-delay: 2s; }
.c3 { width: 50px; height: 50px; top: 5px; left: 100px; animation-delay: 4s; }
.deco-doc {
  position: absolute; width: 70px; top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  opacity: 0.7;
  animation: float 5s ease-in-out infinite;
}
@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}
.deco-doc { animation: floatDoc 5s ease-in-out infinite; }
@keyframes floatDoc {
  0%, 100% { transform: translate(-50%, -50%) rotate(-3deg); }
  50% { transform: translate(-50%, -60%) rotate(3deg); }
}

/* ===== MAIN CONTENT ===== */
.main-content {
  max-width: 1100px;
  margin: 0 auto;
  padding: 40px 32px 80px;
}

/* ===== QUICK ACTIONS ===== */
.quick-actions {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
  margin-bottom: 48px;
}
.qa-card {
  background: white;
  border-radius: 22px;
  padding: 24px 28px;
  display: flex; align-items: center; gap: 18px;
  cursor: pointer;
  border: 2px solid transparent;
  box-shadow: 0 6px 24px rgba(0,0,0,0.05);
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  position: relative; overflow: hidden;
}
.qa-card::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0; bottom: 0;
  opacity: 0; transition: opacity 0.3s;
}
.qa-card.primary::before { background: linear-gradient(135deg, rgba(85,107,47,0.03), rgba(46,139,87,0.05)); }
.qa-card:hover { transform: translateY(-6px); }
.qa-card.primary:hover { box-shadow: 0 16px 40px rgba(85,107,47,0.18); border-color: #8fbc8f; }
.qa-card.primary:hover::before { opacity: 1; }
.qa-card.secondary:hover { box-shadow: 0 16px 40px rgba(205,133,63,0.15); border-color: #daa520; }

.qa-icon {
  width: 60px; height: 60px; flex-shrink: 0;
  background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
  color: #2e7d32;
  border-radius: 18px;
  display: flex; align-items: center; justify-content: center;
  box-shadow: 0 4px 12px rgba(46,125,50,0.15);
}
.qa-icon.secondary-icon {
  background: linear-gradient(135deg, #fff8e1, #ffecb3);
  color: #e65100;
  box-shadow: 0 4px 12px rgba(230,81,0,0.12);
}
.qa-body { flex: 1; }
.qa-body h3 {
  font-family: 'Bai Jamjuree', sans-serif;
  font-size: 18px; font-weight: 700;
  color: #2f4f4f; margin-bottom: 4px;
}
.qa-body p { font-size: 14px; color: #94a3b8; }
.qa-arrow { color: #cbd5e0; transition: all 0.3s; }
.qa-card:hover .qa-arrow { color: #556b2f; transform: translateX(6px); }

/* ===== RECENT SECTION ===== */
.section-head {
  display: flex; justify-content: space-between; align-items: center;
  margin-bottom: 22px;
}
.section-title { display: flex; align-items: center; gap: 12px; }
.section-icon {
  width: 38px; height: 38px;
  background: #f0f7f0;
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  color: #556b2f;
}
.section-title h2 {
  font-family: 'Bai Jamjuree', sans-serif;
  font-size: 20px; font-weight: 700; color: #2f4f4f;
}
.see-all-btn {
  background: none; border: none;
  color: #556b2f; font-size: 14px; font-weight: 600;
  cursor: pointer; padding: 6px 12px;
  border-radius: 8px; transition: background 0.2s;
}
.see-all-btn:hover { background: #f0f7f0; }

/* State boxes */
.state-box {
  background: white; border-radius: 20px;
  padding: 60px 40px;
  text-align: center; color: #a0aec0;
  box-shadow: 0 4px 16px rgba(0,0,0,0.04);
}
.state-box p { font-size: 16px; margin-top: 12px; }
.spinner {
  width: 28px; height: 28px;
  border: 3px solid #e2e8f0;
  border-top-color: #556b2f;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
  margin: 0 auto 12px;
}
@keyframes spin { to { transform: rotate(360deg); } }
.empty-icon { color: #cbd5e0; margin-bottom: 8px; }
.btn-create-now {
  margin-top: 18px;
  padding: 12px 24px;
  background: linear-gradient(135deg, #556b2f, #2e8b57);
  color: white; border: none; border-radius: 12px;
  font-size: 15px; font-weight: 600; cursor: pointer;
  box-shadow: 0 6px 18px rgba(85,107,47,0.3);
  transition: all 0.3s;
}
.btn-create-now:hover { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(85,107,47,0.4); }

/* Meeting List */
.meeting-list { display: flex; flex-direction: column; gap: 14px; }
.meeting-card {
  background: white;
  border-radius: 20px;
  padding: 18px 24px;
  display: flex; align-items: center; gap: 20px;
  box-shadow: 0 3px 14px rgba(0,0,0,0.04);
  border: 1.5px solid #f0f4f0;
  cursor: pointer;
  transition: all 0.25s cubic-bezier(0.25, 0.8, 0.25, 1);
}
.meeting-card:hover {
  transform: translateX(6px);
  box-shadow: 0 8px 28px rgba(85,107,47,0.1);
  border-color: #c8e6c9;
}

/* Date Badge */
.date-badge {
  display: flex; flex-direction: column; align-items: center; justify-content: center;
  min-width: 58px; height: 64px;
  background: linear-gradient(145deg, #f7faf5, #edf7ed);
  border: 1.5px solid #d4edda;
  border-radius: 16px;
  color: #556b2f;
  flex-shrink: 0;
}
.date-day {
  font-family: 'Bai Jamjuree', sans-serif;
  font-size: 24px; font-weight: 800; line-height: 1;
}
.date-month { font-size: 11px; font-weight: 600; opacity: 0.75; margin-top: 2px; }

/* Meeting Info */
.meeting-info { flex: 1; min-width: 0; }
.meeting-name {
  font-size: 16px; font-weight: 600; color: #2f4f4f;
  margin-bottom: 6px;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.meeting-meta { display: flex; gap: 14px; flex-wrap: wrap; }
.meta-tag {
  display: flex; align-items: center; gap: 5px;
  font-size: 13px; color: #94a3b8;
}

/* Edit Button */
.edit-btn {
  width: 38px; height: 38px; flex-shrink: 0;
  border-radius: 12px;
  background: #f7fafc; color: #cbd5e0;
  display: flex; align-items: center; justify-content: center;
  transition: all 0.25s;
}
.meeting-card:hover .edit-btn {
  background: linear-gradient(135deg, #556b2f, #2e8b57);
  color: white;
  box-shadow: 0 4px 12px rgba(85,107,47,0.3);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
  .nav-inner { padding: 14px 20px; }
  .hero-inner { padding: 40px 20px; flex-direction: column; gap: 20px; }
  .hero-title { font-size: 26px; }
  .hero-deco { display: none; }
  .main-content { padding: 28px 20px 60px; }
  .quick-actions { grid-template-columns: 1fr; }
  .meeting-card { padding: 14px 18px; gap: 14px; }
  .meeting-meta { flex-direction: column; gap: 4px; }
  .user-name { display: none; }
}
</style>
