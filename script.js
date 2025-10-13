window.addEventListener("DOMContentLoaded", () => {
  const overlay = document.getElementById("loginOverlay");

  overlay.style.display = "flex";
  document.body.style.overflow = "hidden";

  const loginBtn = document.querySelector("#loginOverlay button");
  loginBtn.addEventListener("click", () => {
    const username = document.getElementById("username").value.trim();
    const email = document.getElementById("email").value.trim();

    if (!username || !email) {
      alert("Please fill in both fields!");
      return;
    }

    // Send data to PHP
    fetch("login.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `username=${encodeURIComponent(username)}&email=${encodeURIComponent(email)}`
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === "success") {
        overlay.style.display = "none";
        document.body.style.overflow = "auto";
        alert(`Welcome, ${username}!`);
      } else {
        alert(data.message);
      }
    })
    .catch(error => {
      console.error("Error:", error);
      alert("Login failed. Please try again.");
    });
  });
});
