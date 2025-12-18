const darkModeToggle = document.getElementById("dark-mode-toggle");

if (localStorage.getItem("theme") === "dark") {
  document.body.classList.add("dark-theme");
  darkModeToggle.checked = true;
}

darkModeToggle.addEventListener("change", () => {
  if (darkModeToggle.checked) {
    document.body.classList.add("dark-theme");
    localStorage.setItem("theme", "dark");
  } else {
    document.body.classList.remove("dark-theme");
    localStorage.setItem("theme", "light");
  }
});
