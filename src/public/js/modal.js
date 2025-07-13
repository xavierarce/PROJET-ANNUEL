document.getElementById("editRoomBtn")?.addEventListener("click", () => {
  document.getElementById("editRoomModal").style.display = "flex";
});

document.getElementById("closeModal")?.addEventListener("click", () => {
  document.getElementById("editRoomModal").style.display = "none";
});

document.getElementById("editRoomModal")?.addEventListener("click", (e) => {
  if (e.target === e.currentTarget) {
    e.currentTarget.style.display = "none";
  }
});
