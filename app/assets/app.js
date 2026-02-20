(function () {
  const year = document.getElementById("year");
  if (year) year.textContent = new Date().getFullYear();

  // Mobile nav
  const toggle = document.querySelector(".nav-toggle");
  const links = document.getElementById("navLinks");
  if (toggle && links) {
    toggle.addEventListener("click", () => {
      const isOpen = links.classList.toggle("open");
      toggle.setAttribute("aria-expanded", String(isOpen));
    });

    // Close on link click
    links.querySelectorAll("a").forEach(a => {
      a.addEventListener("click", () => {
        links.classList.remove("open");
        toggle.setAttribute("aria-expanded", "false");
      });
    });
  }

  // Toast helper
  const toast = document.getElementById("toast");
  let toastTimer = null;
  function showToast(msg) {
    if (!toast) return;
    toast.textContent = msg;
    toast.classList.add("show");
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toast.classList.remove("show"), 1800);
  }

  // Server IP copy
  const serverIpEl = document.getElementById("serverIp");
  const copy1 = document.getElementById("copyIpBtn");
  const copy2 = document.getElementById("copyIpBtn2");

  function copyIp() {
    const ip = serverIpEl ? serverIpEl.textContent.trim() : "";
    if (!ip) return showToast("Add your server IP first.");
    navigator.clipboard.writeText(ip)
      .then(() => showToast("IP copied."))
      .catch(() => showToast("Copy failed — copy manually."));
  }

  if (copy1) copy1.addEventListener("click", copyIp);
  if (copy2) copy2.addEventListener("click", copyIp);

  // Placeholder status (replace later with real endpoint)
  const statusEls = [document.getElementById("serverStatus"), document.getElementById("serverStatus2")];
  const playerEls = [document.getElementById("serverPlayers"), document.getElementById("serverPlayers2")];

  function setStatus(isOnline, players) {
    statusEls.forEach(el => { if (el) el.textContent = isOnline ? "Online" : "Offline"; });
    playerEls.forEach(el => { if (el) el.textContent = typeof players === "number" ? String(players) : "—"; });
  }

  // Default
  setStatus(true, 42);

  // If you later have a JSON endpoint, you can do something like:
  // fetch("/status.json").then(r => r.json()).then(d => setStatus(d.online, d.players)).catch(() => setStatus(false));
})();
