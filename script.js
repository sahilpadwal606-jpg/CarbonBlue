const container = document.getElementById("container");
const registerBtn = document.getElementById("register");
const loginBtn = document.getElementById("login");

registerBtn.addEventListener("click", () => {
  container.classList.add("active");
});

loginBtn.addEventListener("click", () => {
  container.classList.remove("active");
});
document.getElementById("openPopup").addEventListener("click", function () {
    document.getElementById("popup").style.display = "flex";
});

document.querySelector(".close-btn").addEventListener("click", function () {
    document.getElementById("popup").style.display = "none";
});

window.onclick = function (event) {
    if (event.target === document.getElementById("popup")) {
        document.getElementById("popup").style.display = "none";
    }
};
