<template>
  <div class="document-page">
    <!-- Premium Header/Action Bar -->
    <div class="action-bar_container">
      <div class="action-content">
        <button @click="goBack" class="btn-back_premium">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
          </svg>
          ย้อนกลับ
        </button>
        <div class="center-title">
           <div class="mini-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
              </svg>
           </div>
           <span>รายงานการประชุมร่าง</span>
        </div>
        <div class="action-buttons_group">
          <button @click="saveAgendas" class="btn-save_premium" :disabled="loading">
            <template v-if="!loading">
               <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                <polyline points="7 3 7 8 15 8"></polyline>
              </svg>
              <span>บันทึกวาระ</span>
            </template>
            <div v-else class="loader-white"></div>
          </button>
          <button @click="exportPNG" class="btn-export_premium">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
              <polyline points="14 2 14 8 20 8"></polyline>
              <line x1="16" y1="13" x2="8" y2="13"></line>
            </svg>
            <span>PDF</span>
          </button>
        </div>
      </div>
    </div>

    <!-- The Paper Interface -->
    <div class="document-outer_wrapper">
      <div class="paper_sheet">
        <!-- Paper Header -->
        <div class="paper-header">
           <div class="paper-logo">
              <div class="logo-inner">
                 <svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                    <path d="M2 12h20"></path>
                 </svg>
              </div>
           </div>
           <h1 class="paper-title">รายงานการประชุม</h1>
           <div class="paper-divider"></div>
           <div class="meeting-detail_banner">
              <div class="detail-row">
                 <strong>หัวข้อประชุม:</strong> <span>{{ meeting_info?.meeting_title || '...' }}</span>
              </div>
              <div class="detail-row-group">
                 <div class="detail-item">
                    <strong>วันที่:</strong> <span>{{ formatDate(meeting_info?.meeting_date) }}</span>
                 </div>
                 <div class="detail-item">
                    <strong>เวลา:</strong> <span>{{ formatTime(meeting_info?.meeting_time) }} - {{ formatTime(meeting_info?.meeting_time_end) }}</span>
                 </div>
              </div>
              <div class="detail-row">
                 <strong>สถานที่:</strong> <span>{{ meeting_info?.meeting_at || '-' }}</span>
              </div>
           </div>
        </div>

        <!-- Paper Body with Agendas -->
        <div class="paper-body">
          <div class="agenda-item_row">
            <div class="agenda-sidebar">
               <div class="agenda-num">01</div>
               <div class="agenda-line"></div>
            </div>
            <div class="agenda-content_input">
               <h3 class="agenda-label">เรื่องที่ประธานแจ้งให้ที่ประชุมทราบ</h3>
               <textarea v-model="agendas[0]" class="doc-textarea_premium" placeholder="รายละเอียดวาระที่ 1..."></textarea>
            </div>
          </div>

          <div class="agenda-item_row">
            <div class="agenda-sidebar">
               <div class="agenda-num">02</div>
               <div class="agenda-line"></div>
            </div>
            <div class="agenda-content_input">
               <h3 class="agenda-label">รับรองรายงานการประชุมครั้งที่...</h3>
               <textarea v-model="agendas[1]" class="doc-textarea_premium" placeholder="รายละเอียดวาระที่ 2..."></textarea>
            </div>
          </div>

          <div class="agenda-item_row">
            <div class="agenda-sidebar">
               <div class="agenda-num">03</div>
               <div class="agenda-line"></div>
            </div>
            <div class="agenda-content_input">
               <h3 class="agenda-label">เรื่องสืบเนื่อง</h3>
               <textarea v-model="agendas[2]" class="doc-textarea_premium" placeholder="รายละเอียดวาระที่ 3..."></textarea>
            </div>
          </div>

          <div class="agenda-item_row">
            <div class="agenda-sidebar">
               <div class="agenda-num">04</div>
               <div class="agenda-line"></div>
            </div>
            <div class="agenda-content_input">
               <h3 class="agenda-label">เรื่องเพื่อพิจารณา</h3>
               <textarea v-model="agendas[3]" class="doc-textarea_premium" placeholder="รายละเอียดวาระที่ 4..."></textarea>
            </div>
          </div>

          <div class="agenda-item_row">
            <div class="agenda-sidebar">
               <div class="agenda-num">05</div>
            </div>
            <div class="agenda-content_input">
               <h3 class="agenda-label">เรื่องอื่นๆ (ถ้ามี)</h3>
               <textarea v-model="agendas[4]" class="doc-textarea_premium" placeholder="รายละเอียดวาระที่ 5..."></textarea>
            </div>
          </div>
        </div>

        <!-- Document Footer - Signatures -->
        <div class="paper-footer">
          <div class="signature-block">
             <div class="sig-line"></div>
             <p class="sig-name">( ........................................................ )</p>
             <p class="sig-pos">ประธานในที่ประชุม</p>
          </div>
          <div class="signature-block">
             <div class="sig-line"></div>
             <p class="sig-name">( ........................................................ )</p>
             <p class="sig-pos">เลขานุการผู้จดรายงานฯ</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "CreateAgendas",

  data() {
    return {
      meeting_id: null,
      meeting_info: null,
      agendas: ["", "", "", "", ""],
      loading: false
    };
  }, 

  async mounted() {

  this.meeting_id = Number(this.$route.params.id);

  console.log("Meeting ID:", this.meeting_id);

  if (this.meeting_id) {
    await this.fetchMeetingInfo();
  }

},

  methods: {

    goBack() {
      this.$router.push("/list");
    },

    async fetchMeetingInfo() {

  try {

    this.loading = true;

    const res = await fetch(
      `http://localhost/project/backend/get_meeting.php?meeting_id=${this.meeting_id}`
    );

    const data = await res.json();

    console.log("meeting data:", data);

    if (data.success) {

      this.meeting_info = data.data;

      this.agendas = ["", "", "", "", ""];

      if (this.meeting_info.agendas) {

            this.meeting_info.agendas.forEach(item => {

              const index = item.agenda_order - 1;

              if (index >= 0 && index < 5) {
                this.agendas[index] = item.agenda_text;
              }

            });
      }

    } else {

      alert("ไม่พบข้อมูลการประชุม");

    }

  } catch (err) {

    console.error("Fetch error:", err);
    alert("ไม่สามารถโหลดข้อมูลได้");

  } finally {

    this.loading = false;

  }

},

    formatDate(dateStr) {

      if (!dateStr) return "-";

      return new Date(dateStr).toLocaleDateString("th-TH", {
        year: "numeric",
        month: "long",
        day: "numeric"
      });

    },

    formatTime(timeStr) {

      if (!timeStr) return "-";

      return timeStr.substring(0, 5) + " น.";

    },

    async saveAgendas() {

      if (!this.meeting_id) {
       alert("ไม่พบข้อมูลการประชุม");
      }

      if (this.loading) return;

      this.loading = true;

      try {

        const payload = {

          meeting_id: this.meeting_id,

          agendas: this.agendas
            .map((text, index) => ({
              agenda_order: index + 1,
              agenda_text: text
            }))
            .filter(a => a.agenda_text.trim() !== "")

            
        };

        console.log("payload:", payload);

        const res = await fetch(
          "http://localhost/project/backend/save_agendas.php",
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify(payload)
          }
        );

        const text = await res.text();
        console.log("server:", text);

        const result = JSON.parse(text);

        if (result.success) {

          alert("✓ บันทึกรายงานการประชุมเรียบร้อยแล้ว");

        } else {

          alert("❌ เกิดข้อผิดพลาด: " +
            (result.message || "ไม่ทราบสาเหตุ"));

        }

      } catch (err) {

        console.error(err);
        alert("❌ ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้");

      } finally {

        this.loading = false;

      }

    },

    exportPNG() {

      if (!this.meeting_id) {
        alert("ไม่พบข้อมูลการประชุม");
        return;
      }

      window.open(
        `http://localhost/project/backend/export_png.php?meeting_id=${this.meeting_id}`,
        "_blank"
      );
    }
  }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=Bai+Jamjuree:wght@400;500;600;700&display=swap');

.document-page {
  min-height: 100vh;
  background: #fdfcf8; /* Light warm cream */
  font-family: 'Sarabun', -apple-system, sans-serif;
  color: #2f4f4f;
  padding-bottom: 80px;
}

/* Action Bar Styling */
.action-bar_container {
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(15px);
  height: 80px;
  position: sticky;
  top: 0;
  z-index: 1000;
  border-bottom: 2px solid rgba(85, 107, 47, 0.1);
  display: flex;
  align-items: center;
}

.action-content {
  width: 100%;
  max-width: 1000px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 2fr 1.5fr;
  align-items: center;
  padding: 0 40px;
}

.btn-back_premium {
  justify-self: start;
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 18px;
  background: white;
  color: #556b2f;
  border: 2px solid #556b2f;
  border-radius: 14px;
  font-weight: 700;
  font-size: 15px;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.btn-back_premium:hover {
  background: #556b2f;
  color: white;
  transform: translateX(-5px);
  box-shadow: 0 5px 15px rgba(85, 107, 47, 0.2);
}

.center-title {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  font-family: 'Bai Jamjuree', sans-serif;
  font-weight: 700;
  font-size: 18px;
  color: #2f4f4f;
}

.mini-icon {
  width: 32px;
  height: 32px;
  background: #f0f7f0;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #556b2f;
}

.action-buttons_group {
  justify-self: end;
  display: flex;
  gap: 14px;
}

.btn-save_premium, .btn-export_premium {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 12px 24px;
  border-radius: 14px;
  font-weight: 700;
  font-size: 15px;
  cursor: pointer;
  border: none;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.btn-save_premium {
  background: linear-gradient(135deg, #556b2f 0%, #2e8b57 100%);
  color: white;
  box-shadow: 0 6px 20px rgba(46, 139, 87, 0.3);
}

.btn-save_premium:hover:not(:disabled) {
  transform: translateY(-3px);
  box-shadow: 0 10px 30px rgba(46, 139, 87, 0.4);
}

.btn-save_premium:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-export_premium {
  background: white;
  color: #cd853f;
  border: 2px solid #cd853f;
}

.btn-export_premium:hover {
  background: #cd853f;
  color: white;
  transform: translateY(-3px);
  box-shadow: 0 6px 20px rgba(205, 133, 63, 0.2);
}

/* Loader Styles */
.loader-white {
  width: 18px;
  height: 18px;
  border: 2px solid rgba(255,255,255,0.3);
  border-top-color: white;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin { to { transform: rotate(360deg); } }

/* Paper Container Structure */
.document-outer_wrapper {
  max-width: 1000px;
  margin: 50px auto;
  padding: 0 30px;
}

.paper_sheet {
  background: #fff;
  min-height: 1200px;
  padding: 80px 100px;
  border-radius: 4px;
  box-shadow: 0 15px 60px rgba(0,0,0,0.06);
  position: relative;
  border: 1px solid rgba(0,0,0,0.03);
}

.paper_sheet::before {
  content: '';
  position: absolute;
  top: 0; left: 15px; bottom: 0;
  width: 2px;
  background: rgba(85, 107, 47, 0.05);
}

.paper-header {
  text-align: center;
  margin-bottom: 60px;
}

.paper-logo {
  display: inline-flex;
  padding: 15px;
  background: #fcfdf9;
  border-radius: 20px;
  margin-bottom: 20px;
  box-shadow: 0 4px 15px rgba(85, 107, 47, 0.1);
}

.logo-inner {
  color: #556b2f;
}

.paper-title {
  font-family: 'Bai Jamjuree', sans-serif;
  font-size: 32px;
  font-weight: 800;
  color: #2f4f4f;
  margin-bottom: 20px;
}

.paper-divider {
  width: 60px;
  height: 4px;
  background: #8fbc8f;
  margin: 0 auto 30px;
  border-radius: 2px;
}

.meeting-detail_banner {
  display: flex;
  flex-direction: column;
  gap: 12px;
  background: #f7faf5;
  padding: 24px 35px;
  border-radius: 20px;
  font-size: 17px;
  color: #556b2f;
  border: 1px dashed #8fbc8f;
  text-align: left;
  max-width: 600px;
  margin: 0 auto 30px;
}

.detail-row {
  display: flex;
  gap: 10px;
}

.detail-row-group {
  display: flex;
  gap: 40px;
}

.detail-item {
  display: flex;
  gap: 10px;
}

.participant-text {
  font-size: 15px;
  color: #64748b;
  font-style: italic;
}

/* Agenda Content Row */
.paper-body {
  display: flex;
  flex-direction: column;
  gap: 45px;
}

.agenda-item_row {
  display: grid;
  grid-template-columns: 50px 1fr;
  gap: 20px;
}

.agenda-sidebar {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.agenda-num {
  width: 38px;
  height: 38px;
  background: #556b2f;
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-family: 'Bai Jamjuree', sans-serif;
  position: relative;
  z-index: 2;
  box-shadow: 0 4px 10px rgba(85, 107, 47, 0.3);
}

.agenda-line {
  flex: 1;
  width: 2px;
  background: #e2e8f0;
  margin-top: 5px;
}

.agenda-content_input {
  padding-top: 5px;
}

.agenda-label {
  font-family: 'Bai Jamjuree', sans-serif;
  font-size: 19px;
  font-weight: 700;
  color: #2f4f4f;
  margin-bottom: 12px;
  padding-left: 5px;
}

.doc-textarea_premium {
  width: 100%;
  min-height: 140px;
  padding: 20px;
  background: #fbfbfb;
  border: 2px solid #f1f1f1;
  border-radius: 18px;
  font-size: 17px;
  line-height: 1.7;
  color: #334e4e;
  resize: vertical;
  transition: all 0.3s ease;
  font-family: 'Sarabun', sans-serif;
}

.doc-textarea_premium:hover {
  background: #fdfdfd;
  border-color: #e2e8f0;
}

.doc-textarea_premium:focus {
  outline: none;
  background: white;
  border-color: #8fbc8f;
  box-shadow: 0 10px 30px rgba(85, 107, 47, 0.05);
}

/* Signature Section */
.paper-footer {
  margin-top: 100px;
  padding-top: 50px;
  border-top: 1px solid #f1f5f9;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 80px;
}

.signature-block {
  text-align: center;
}

.sig-line {
  margin: 0 auto 15px;
  width: 200px;
  height: 1px;
  background: #e2e8f0;
}

.sig-name {
  font-size: 15px;
  color: #64748b;
  margin-bottom: 6px;
}

.sig-pos {
  font-size: 16px;
  font-weight: 600;
  color: #556b2f;
}

/* Responsive Handling */
@media (max-width: 900px) {
  .paper_sheet { padding: 50px 40px; }
  .action-content { grid-template-columns: 1fr auto; padding: 0 20px; gap: 10px; }
  .center-title { display: none; }
}

@media (max-width: 600px) {
  .paper-footer { grid-template-columns: 1fr; gap: 40px; }
  .paper_sheet { padding: 40px 20px; }
  .agenda-item_row { grid-template-columns: 1fr; }
  .agenda-sidebar { display: none; }
}
</style>
