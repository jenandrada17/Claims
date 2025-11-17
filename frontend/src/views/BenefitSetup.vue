<template>
  <header class="header">
    <h1>My Header</h1>
  </header>

  <div class="content-wrapper">
    <section class="wide-content">
      <p>Mas mahaba ako kaysa sa header 😎</p>
    </section>
  </div>
</template>

<style scoped>
/* HEADER — standard container width */
.header {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  background: #eee;
  border-bottom: 1px solid #ccc;
  text-align: center;
}

/* WRAPPER — normal container */
.content-wrapper {
  max-width: 800px;
  margin: 0 auto;
}

/* WIDE CONTENT — FULL SCREEN (100vw) */
.wide-content {
  width: 100vw;              /* Full width ng screen */
  margin-left: calc(50% - 50vw); /* remove container limitation */
  
  background: #d9eafd;
  padding: 24px;
  text-align: center;
}
</style>
