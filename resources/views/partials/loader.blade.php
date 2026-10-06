<!-- =========================================================
     PREMIUM GLOBAL PAGE LOADER (ENTER & REFRESH)
========================================================= -->
<div id="appPageLoader" class="app-page-loader" role="status" aria-live="polite" aria-label="Loading page">
    <div class="app-loader-card">
        <!-- Glowing Ambient Rings -->
        <div class="app-loader-halo"></div>

        <div class="app-loader-orbit-wrap">
            <div class="app-loader-orbit orbit-1"></div>
            <div class="app-loader-orbit orbit-2"></div>
            <div class="app-loader-orbit orbit-3"></div>
            
            <div class="app-loader-center-badge">
                <svg class="app-loader-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                </svg>
            </div>
        </div>

        <!-- Typography & Dots -->
        <div class="app-loader-caption">
            <span class="app-loader-text">Loading</span>
            <span class="app-loader-dots">
                <span class="dot d1"></span>
                <span class="dot d2"></span>
                <span class="dot d3"></span>
            </span>
        </div>

        <!-- Micro Progress Bar -->
        <div class="app-loader-bar-wrap">
            <div class="app-loader-bar-fill"></div>
        </div>
    </div>
</div>

<style>
/* =========================================================
   PAGE LOADER STYLES
========================================================= */
.app-page-loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    height: 100dvh;
    z-index: 999999;
    display: flex;
    align-items: center;
    justify-content: center;
    background: radial-gradient(circle at 50% 40%, rgba(255, 245, 245, 0.97), rgba(239, 206, 206, 0.98));
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    opacity: 1;
    visibility: visible;
    transition: opacity 0.45s cubic-bezier(0.4, 0, 0.2, 1),
                visibility 0.45s cubic-bezier(0.4, 0, 0.2, 1),
                transform 0.45s cubic-bezier(0.4, 0, 0.2, 1);
    pointer-events: all;
    user-select: none;
    -webkit-user-select: none;
}

.app-page-loader.app-page-loader-hidden {
    opacity: 0;
    visibility: hidden;
    transform: scale(1.025);
    pointer-events: none;
}

.app-loader-card {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 34px 40px 28px;
    border-radius: 28px;
    background: rgba(255, 255, 255, 0.65);
    border: 1px solid rgba(255, 255, 255, 0.9);
    box-shadow: 0 20px 50px rgba(189, 98, 98, 0.16),
                0 6px 18px rgba(0, 0, 0, 0.04),
                inset 0 1px 1px rgba(255, 255, 255, 0.9);
    animation: loaderCardEnter 0.4s cubic-bezier(0.16, 1, 0.3, 1) both;
}

@keyframes loaderCardEnter {
    from {
        opacity: 0;
        transform: translateY(12px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.app-loader-halo {
    position: absolute;
    width: 140px;
    height: 140px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(217, 134, 134, 0.35) 0%, rgba(217, 134, 134, 0) 70%);
    filter: blur(14px);
    z-index: 0;
    animation: loaderHaloPulse 2.4s ease-in-out infinite;
}

@keyframes loaderHaloPulse {
    0%, 100% {
        transform: scale(0.9);
        opacity: 0.6;
    }
    50% {
        transform: scale(1.25);
        opacity: 1;
    }
}

.app-loader-orbit-wrap {
    position: relative;
    width: 76px;
    height: 76px;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1;
    margin-bottom: 20px;
}

.app-loader-orbit {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    box-sizing: border-box;
}

.app-loader-orbit.orbit-1 {
    border: 2.5px solid transparent;
    border-top-color: #d98686;
    border-right-color: #bd6262;
    animation: loaderSpin 1.1s cubic-bezier(0.55, 0.15, 0.45, 0.85) infinite;
}

.app-loader-orbit.orbit-2 {
    inset: 6px;
    border: 2px solid transparent;
    border-bottom-color: #e59f9f;
    border-left-color: #d98686;
    animation: loaderSpinRev 1.6s cubic-bezier(0.55, 0.15, 0.45, 0.85) infinite;
}

.app-loader-orbit.orbit-3 {
    inset: 12px;
    border: 1.5px dashed rgba(217, 134, 134, 0.45);
    animation: loaderSpin 3.2s linear infinite;
}

@keyframes loaderSpin {
    to {
        transform: rotate(360deg);
    }
}

@keyframes loaderSpinRev {
    to {
        transform: rotate(-360deg);
    }
}

.app-loader-center-badge {
    position: relative;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: linear-gradient(135deg, #d98686 0%, #ba5d5d 100%);
    box-shadow: 0 4px 12px rgba(186, 93, 93, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    animation: loaderBadgeBreath 2s ease-in-out infinite;
}

@keyframes loaderBadgeBreath {
    0%, 100% {
        transform: scale(0.96);
        box-shadow: 0 4px 12px rgba(186, 93, 93, 0.35);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 6px 18px rgba(186, 93, 93, 0.55);
    }
}

.app-loader-svg {
    width: 19px;
    height: 19px;
    color: #ffffff;
}

.app-loader-caption {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 14.5px;
    font-weight: 700;
    letter-spacing: 0.3px;
    color: #6a4040;
    margin-bottom: 14px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
}

.app-loader-text {
    background: linear-gradient(135deg, #743e3e 0%, #aa5454 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.app-loader-dots {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    margin-left: 2px;
}

.app-loader-dots .dot {
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: #bd6262;
    animation: loaderDotBounce 1.2s ease-in-out infinite;
}

.app-loader-dots .dot.d1 {
    animation-delay: 0s;
}

.app-loader-dots .dot.d2 {
    animation-delay: 0.2s;
}

.app-loader-dots .dot.d3 {
    animation-delay: 0.4s;
}

@keyframes loaderDotBounce {
    0%, 80%, 100% {
        transform: translateY(0);
        opacity: 0.35;
    }
    40% {
        transform: translateY(-4px);
        opacity: 1;
    }
}

.app-loader-bar-wrap {
    position: relative;
    width: 140px;
    height: 4px;
    background: rgba(217, 134, 134, 0.18);
    border-radius: 999px;
    overflow: hidden;
    z-index: 1;
}

.app-loader-bar-fill {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 40%;
    background: linear-gradient(90deg, #d98686, #c25757);
    border-radius: 999px;
    box-shadow: 0 0 8px rgba(194, 87, 87, 0.5);
    animation: loaderBarMove 1.6s cubic-bezier(0.4, 0, 0.2, 1) infinite;
}

@keyframes loaderBarMove {
    0% {
        left: -40%;
        width: 30%;
    }
    50% {
        width: 55%;
    }
    100% {
        left: 100%;
        width: 25%;
    }
}
</style>

<script>
(function() {
    let loaderDismissed = false;

    function hidePageLoader() {
        const loader = document.getElementById('appPageLoader');
        if (!loader) return;

        loader.classList.add('app-page-loader-hidden');

        setTimeout(function() {
            if (loader && loader.classList.contains('app-page-loader-hidden')) {
                loader.style.display = 'none';
            }
        }, 500);
    }

    function showPageLoader() {
        const loader = document.getElementById('appPageLoader');
        if (!loader) return;

        loader.style.display = 'flex';
        // Force reflow
        void loader.offsetWidth;
        loader.classList.remove('app-page-loader-hidden');

        // Safety fallback so link click never leaves user stranded
        setTimeout(hidePageLoader, 4000);
    }

    // Dismiss on window load
    if (document.readyState === 'complete') {
        setTimeout(hidePageLoader, 200);
    } else {
        window.addEventListener('load', function() {
            setTimeout(hidePageLoader, 250);
        });
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(hidePageLoader, 1400);
        });
    }

    // Hard fallback timeout
    setTimeout(hidePageLoader, 2600);

    // Support browser back/forward cache (bfcache)
    window.addEventListener('pageshow', function() {
        hidePageLoader();
    });

    // Smooth navigation: show loader on internal link clicks
    document.addEventListener('click', function(event) {
        const link = event.target.closest('a');
        if (!link) return;

        const href = link.getAttribute('href');
        const target = link.getAttribute('target');

        if (!href || href === '#' || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:') || target === '_blank') {
            return;
        }

        if (event.ctrlKey || event.metaKey || event.shiftKey || event.altKey || event.defaultPrevented) {
            return;
        }

        showPageLoader();
    }, true);

    // Show loader on standard form submissions
    document.addEventListener('submit', function(event) {
        const form = event.target;
        if (!form || form.getAttribute('target') === '_blank' || event.defaultPrevented) {
            return;
        }

        showPageLoader();
    }, true);
})();
</script>
