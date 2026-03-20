<template>
  <div class="login-wrapper">
    <div class="background-gradient"></div>
    <div class="login-container">
      <div class="login-header">
        <div class="logo-circle">
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
          </svg>
        </div>
        <h2>เข้าสู่ระบบ</h2>
        <p class="subtitle">Hatyai Hospital</p>
      </div>

      <div class="form-content">
        <div class="form-group">
          <label>ชื่อผู้ใช้</label>
          <div class="input-wrapper">
            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <input
              v-model="uname"
              type="text"
              placeholder="กรอกชื่อผู้ใช้"
            />
          </div>
        </div>

        <div class="form-group">
          <label>รหัสผ่าน</label>
          <div class="input-wrapper">
            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            <input
              v-model="psword"
              type="password"
              placeholder="กรอกรหัสผ่าน"
            />
          </div>
        </div>

        <button @click="login" :disabled="loading" class="login-button">
          <span v-if="loading" class="loading-spinner"></span>
          {{ loading ? "กำลังเข้าสู่ระบบ..." : "เข้าสู่ระบบ" }}
        </button>

        <div v-if="error" class="error-message">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
          </svg>
          <span>{{ error }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Login",

  data() {
    return {
      uname: "",
      psword: "",
      error: "",
      loading: false
    };
  },

  methods: {
    async login() {
      this.error = "";

      if (!this.uname || !this.psword) {
        this.error = "กรุณากรอกชื่อผู้ใช้และรหัสผ่าน";
        return;
      }

      this.loading = true;

      try {
        const formData = new FormData();
        formData.append("fnc", "authenUserLogin");
        formData.append("uname", this.uname);
        formData.append("psword", this.psword);

        const res = await axios.post(
          "http://61.19.25.200/api/gtw/api-gtw.php",
          formData
        );

        console.log("LOGIN RESPONSE TYPE 👉", typeof res.data);
        console.log("LOGIN RESPONSE FULL 👉", res.data);
        
        if (typeof res.data === "object") {

          if (res.data.HR_CID) {
            const user = {
              cid: res.data.HR_CID,
              uname: res.data.uname || this.uname
            };

            localStorage.setItem("user", JSON.stringify(user));

            console.log("LOGIN SUCCESS (OBJECT)");
            this.$router.push("/dashboard");
            return;
          }

          if (res.data.status === 300) {
            console.log("LOGIN SUCCESS (STATUS 300)");
            this.$router.push("/dashboard");
            return;
          }
        }

        if (res.data == 300) {
          console.log("LOGIN SUCCESS (NUMBER 300)");
          this.$router.push("/dashboard");
          return;
        }

        console.error("LOGIN FAILED 👉", res.data);
        this.error = "เข้าสู่ระบบไม่สำเร็จ";

      } catch (err) {
        console.error("LOGIN ERROR 👉", err);
        this.error = "ไม่สามารถเชื่อมต่อระบบได้";
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>


<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

* {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

.login-wrapper {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: linear-gradient(135deg, #8fbc8f 0%, #556b2f 100%); /* Natural Green Gradient */
}

.background-gradient {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: 
    radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
    radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
    radial-gradient(circle at 40% 20%, rgba(240, 255, 240, 0.1) 0%, transparent 50%);
  animation: gradientShift 15s ease infinite;
}

@keyframes gradientShift {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.8; }
}

.login-container {
  position: relative;
  width: 440px;
  padding: 48px;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(20px);
  border-radius: 24px;
  box-shadow: 
    0 20px 60px rgba(0, 0, 0, 0.3),
    0 0 0 1px rgba(255, 255, 255, 0.5) inset;
  animation: slideUpFadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes slideUpFadeIn {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.login-header {
  text-align: center;
  margin-bottom: 36px;
}

.logo-circle {
  width: 72px;
  height: 72px;
  margin: 0 auto 20px;
  background: linear-gradient(135deg, #556b2f 0%, #8fbc8f 100%); /* Olive to Sea Green */
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 8px 24px rgba(85, 107, 47, 0.4);
  animation: float 3s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-8px); }
}

.logo-circle svg {
  color: white;
}

.login-header h2 {
  margin: 0 0 8px 0;
  font-size: 32px;
  font-weight: 700;
  background: none;
  color: #2f4f4f; /* Dark Slate Gray */
  -webkit-text-fill-color: initial;
}

.subtitle {
  margin: 0;
  color: #556b2f;
  font-size: 15px;
  font-weight: 500;
}

.form-content {
  margin-top: 32px;
}

.form-group {
  margin-bottom: 24px;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  font-size: 14px;
  font-weight: 600;
  color: #2f4f4f;
  letter-spacing: 0.01em;
}

.input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}

.input-icon {
  position: absolute;
  left: 16px;
  color: #94a3b8;
  pointer-events: none;
  transition: all 0.3s ease;
}

.input-wrapper:focus-within .input-icon {
  color: #556b2f;
  transform: scale(1.1);
}

.form-group input {
  width: 100%;
  padding: 14px 16px 14px 48px;
  font-size: 15px;
  color: #1e293b;
  background: #fdfcf8;
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  box-sizing: border-box;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  font-weight: 500;
}

.form-group input::placeholder {
  color: #94a3b8;
  font-weight: 400;
}

.form-group input:focus {
  outline: none;
  background: white;
  border-color: #556b2f;
  box-shadow: 0 0 0 4px rgba(85, 107, 47, 0.1);
  transform: translateY(-1px);
}

.form-group input:hover:not(:focus) {
  border-color: #cbd5e1;
}

.login-button {
  width: 100%;
  padding: 16px;
  margin-top: 12px;
  font-size: 16px;
  font-weight: 600;
  color: white;
  background: linear-gradient(135deg, #556b2f 0%, #228b22 100%); /* Forest Green */
  border: none;
  border-radius: 12px;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 4px 16px rgba(34, 139, 34, 0.4);
  position: relative;
  overflow: hidden;
}

.login-button::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
  transition: left 0.5s;
}

.login-button:hover:not(:disabled)::before {
  left: 100%;
}

.login-button:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(34, 139, 34, 0.5);
}

.login-button:active:not(:disabled) {
  transform: translateY(0);
  box-shadow: 0 2px 8px rgba(34, 139, 34, 0.4);
}

.login-button:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.loading-spinner {
  display: inline-block;
  width: 16px;
  height: 16px;
  margin-right: 8px;
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-top-color: white;
  border-radius: 50%;
  animation: spin 0.6s linear infinite;
  vertical-align: middle;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.error-message {
  margin-top: 20px;
  padding: 14px 16px;
  background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
  border: 1px solid #fca5a5;
  border-radius: 12px;
  color: #dc2626;
  font-size: 14px;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 10px;
  animation: shake 0.4s cubic-bezier(0.36, 0.07, 0.19, 0.97);
}

@keyframes shake {
  0%, 100% { transform: translateX(0); }
  25% { transform: translateX(-8px); }
  75% { transform: translateX(8px); }
}

.error-message svg {
  flex-shrink: 0;
}

/* Responsive Design */
@media (max-width: 500px) {
  .login-container {
    width: 90%;
    padding: 32px 24px;
    border-radius: 20px;
  }
  
  .login-header h2 {
    font-size: 28px;
  }
  
  .logo-circle {
    width: 64px;
    height: 64px;
  }
}
</style>

