<script setup>
// App.vue ทำหน้าที่เป็น layout หลัก
// ไม่ต้อง import component ใด ๆ
</script>

<template>
  <!-- Router จะเป็นคนควบคุมว่าแสดงหน้าอะไร -->
  <router-view />
</template>

<style>
/* ใส่ global style ได้ (หรือปล่อยว่างก็ได้) */
html, body {
  margin: 0;
  padding: 0;
  font-family: sans-serif;
}
</style>
