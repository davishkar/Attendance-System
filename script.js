function goTo(page) {
    window.location.href = page;
}

function toggleMenu() {
    const menu = document.querySelector("nav ul");
    if (menu) {
        menu.classList.toggle("active");
    }
}
function toggleStudent(id) {
    const btn = document.getElementById("btn-" + id);
    const chk = document.getElementById("chk-" + id);

    if (!btn || !chk) {
        return;
    }

    btn.classList.toggle("active");
    chk.checked = btn.classList.contains("active");
}

function calcTotal() {
    const bandhu = parseInt(document.getElementById("bandhu")?.value, 10) || 0;
    const bhagini = parseInt(document.getElementById("bhagini")?.value, 10) || 0;
    const total = document.getElementById("total");

    if (total) {
        total.value = bandhu + bhagini;
    }
}
