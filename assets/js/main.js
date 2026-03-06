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
const SIDEBAR_STATE_KEY = 'pamer-sidebar-state';

function getSavedSidebarState() {
    try {
        return localStorage.getItem(SIDEBAR_STATE_KEY);
    } catch (error) {
        return null;
    }
}

function saveSidebarState(state) {
    try {
        localStorage.setItem(SIDEBAR_STATE_KEY, state);
    } catch (error) {
        // Ignore storage errors and keep current visual state only.
    }
}

function emitSidebarStateChange(collapsed) {
    window.dispatchEvent(new CustomEvent('pamer:sidebar-change', {
        detail: {
            collapsed: !!collapsed
        }
    }));
}

function applySidebarState() {
    const sidebar = document.getElementById('sidebar');
    const app = document.getElementById('app');
    if (!sidebar || !app) return;

    const isDesktop = window.innerWidth >= 1200;
    const savedState = getSavedSidebarState();
    const shouldCollapse = savedState === 'collapsed';

    document.documentElement.classList.toggle('sidebar-pref-collapsed', shouldCollapse);

    if (isDesktop) {
        sidebar.classList.add('active');
        app.classList.toggle('sidebar-collapsed', shouldCollapse);
        emitSidebarStateChange(shouldCollapse);
        return;
    }

    app.classList.remove('sidebar-collapsed');
    sidebar.classList.toggle('active', !shouldCollapse);
    emitSidebarStateChange(shouldCollapse);
}

function setSidebarCollapsed(collapsed) {
    const sidebar = document.getElementById('sidebar');
    const app = document.getElementById('app');
    if (!sidebar || !app) return;

    const isDesktop = window.innerWidth >= 1200;
    saveSidebarState(collapsed ? 'collapsed' : 'expanded');
    document.documentElement.classList.toggle('sidebar-pref-collapsed', collapsed);

    if (isDesktop) {
        sidebar.classList.add('active');
        app.classList.toggle('sidebar-collapsed', collapsed);
        emitSidebarStateChange(collapsed);
        return;
    }

    app.classList.remove('sidebar-collapsed');
    sidebar.classList.toggle('active', !collapsed);
    emitSidebarStateChange(collapsed);
}

window.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    if (sidebar && !getSavedSidebarState() && window.innerWidth < 1200) {
        saveSidebarState('collapsed');
    }
    applySidebarState();
});

window.addEventListener('resize', () => {
    applySidebarState();
});

// Burger menu button
document.querySelectorAll('.burger-btn').forEach((burgerBtn) => {
    burgerBtn.addEventListener('click', (event) => {
        event.preventDefault();
        const app = document.getElementById('app');
        if (window.innerWidth >= 1200 && app) {
            setSidebarCollapsed(!app.classList.contains('sidebar-collapsed'));
            return;
        }
        const sidebar = document.getElementById('sidebar');
        setSidebarCollapsed(sidebar ? sidebar.classList.contains('active') : true);
    });
});

// Sidebar hide button
document.querySelectorAll('.sidebar-hide').forEach((sidebarHide) => {
    sidebarHide.addEventListener('click', (event) => {
        event.preventDefault();
        const app = document.getElementById('app');
        if (window.innerWidth >= 1200 && app) {
            setSidebarCollapsed(true);
            return;
        }
        setSidebarCollapsed(true);
    });
});

// Perfect Scrollbar Init
if (typeof PerfectScrollbar === 'function') {
    const container = document.querySelector(".sidebar-menu");
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
