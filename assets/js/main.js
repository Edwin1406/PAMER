function slideToggle(t, e, o) {
    t.clientHeight === 0 ? j(t, e, o, true) : j(t, e, o);
}

function slideUp(t, e, o) {
    j(t, e, o);
}

function slideDown(t, e, o) {
    j(t, e, o, true);
}

function j(t, e, o, i) {
    if (typeof e === "undefined") e = 400;
    if (typeof i === "undefined") i = false;

    t.style.overflow = "hidden";
    if (i) t.style.display = "block";

    var p;
    const l = window.getComputedStyle(t);
    const n = parseFloat(l.getPropertyValue("height"));
    const a = parseFloat(l.getPropertyValue("padding-top"));
    const s = parseFloat(l.getPropertyValue("padding-bottom"));
    const r = parseFloat(l.getPropertyValue("margin-top"));
    const d = parseFloat(l.getPropertyValue("margin-bottom"));

    const g = n / e,
        y = a / e,
        m = s / e,
        u = r / e,
        h = d / e;

    window.requestAnimationFrame(function l(x) {
        if (typeof p === "undefined") p = x;
        const f = x - p;

        if (i) {
            t.style.height = g * f + "px";
            t.style.paddingTop = y * f + "px";
            t.style.paddingBottom = m * f + "px";
            t.style.marginTop = u * f + "px";
            t.style.marginBottom = h * f + "px";
        } else {
            t.style.height = n - g * f + "px";
            t.style.paddingTop = a - y * f + "px";
            t.style.paddingBottom = s - m * f + "px";
            t.style.marginTop = r - u * f + "px";
            t.style.marginBottom = d - h * f + "px";
        }

        if (f >= e) {
            t.style.height = "";
            t.style.paddingTop = "";
            t.style.paddingBottom = "";
            t.style.marginTop = "";
            t.style.marginBottom = "";
            t.style.overflow = "";
            if (!i) t.style.display = "none";
            if (typeof o === "function") o();
        } else {
            window.requestAnimationFrame(l);
        }
    });
}

// Sidebar toggling with submenu
let sidebarItems = document.querySelectorAll('.sidebar-item.has-sub');
for (let i = 0; i < sidebarItems.length; i++) {
    let sidebarItem = sidebarItems[i];
    let sidebarLink = sidebarItem.querySelector('.sidebar-link');
    let submenu = sidebarItem.querySelector('.submenu');

    if (sidebarLink && submenu) {
        sidebarLink.addEventListener('click', function (e) {
            e.preventDefault();

            if (submenu.classList.contains('active')) submenu.style.display = "block";
            if (submenu.style.display === "none") submenu.classList.add('active');
            else submenu.classList.remove('active');

            slideToggle(submenu, 300);
        });
    }
}

// Sidebar toggle on load and resize
window.addEventListener('DOMContentLoaded', () => {
    let w = window.innerWidth;
    const sidebar = document.getElementById('sidebar');
    if (sidebar && w < 1200) {
        sidebar.classList.remove('active');
    }
});

window.addEventListener('resize', () => {
    let w = window.innerWidth;
    const sidebar = document.getElementById('sidebar');
    if (sidebar) {
        if (w < 1200) {
            sidebar.classList.remove('active');
        } else {
            sidebar.classList.add('active');
        }
    }
});

// Burger menu button
const burgerBtn = document.querySelector('.burger-btn');
if (burgerBtn) {
    burgerBtn.addEventListener('click', () => {
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            sidebar.classList.toggle('active');
        }
    });
}

// Sidebar hide button
const sidebarHide = document.querySelector('.sidebar-hide');
if (sidebarHide) {
    sidebarHide.addEventListener('click', () => {
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            sidebar.classList.toggle('active');
        }
    });
}

// Perfect Scrollbar Init
if (typeof PerfectScrollbar === 'function') {
    const container = document.querySelector(".sidebar-wrapper");
    if (container) {
        const ps = new PerfectScrollbar(container, {
            wheelPropagation: false
        });
    }
}

// Scroll active item into view
const activeItem = document.querySelector('.sidebar-item.active');
if (activeItem) {
    activeItem.scrollIntoView(false);
}
