@php
    $widgetColor = Setting::get('visitor_widget_color', '#0E7A32');
    $widgetText = Setting::get('visitor_widget_text', 'PERSONNES SUR LE SITE');
    $widgetPosition = Setting::get('visitor_widget_position', 'after_hero');
@endphp

@if($widgetPosition === 'floating')
<div id="vw-floating" class="vw-floating" onclick="vwTogglePopup()">
    <span class="vw-dot"></span>
    <span class="vw-float-count" id="vw-online-float">{{ $onlineNow ?? 0 }}</span>
    <span class="vw-float-label">en ligne</span>
</div>
@else
<section class="vw-bar" style="background:{{ $widgetColor }};" onclick="vwTogglePopup()">
    <div class="vw-bar-inner">
        <span class="vw-dot"></span>
        <span class="vw-count" id="vw-online-bar">{{ $onlineNow ?? 0 }}</span>
        <span class="vw-label">{{ $widgetText }}</span>
        <span class="vw-expand"><i class="bi bi-chevron-down"></i></span>
    </div>
</section>
@endif

{{-- Popup overlay --}}
<div id="vw-popup-overlay" class="vw-popup-overlay" onclick="vwTogglePopup()">
    <div class="vw-popup" onclick="event.stopPropagation()">
        <button class="vw-popup-close" onclick="vwTogglePopup()">&times;</button>
        <div class="vw-popup-header" style="background:{{ $widgetColor }};">
            <span class="vw-dot vw-dot-lg"></span>
            <span class="vw-popup-online" id="vw-popup-count">{{ $onlineNow ?? 0 }}</span>
            <span class="vw-popup-online-label">{{ $widgetText }}</span>
        </div>
        <div class="vw-popup-body">
            <div class="vw-stat-row">
                <div class="vw-stat-item">
                    <i class="bi bi-person-check" style="color:{{ $widgetColor }};"></i>
                    <div class="vw-stat-val" id="vw-visitors-today">--</div>
                    <div class="vw-stat-lbl">Visiteurs aujourd'hui</div>
                </div>
                <div class="vw-stat-item">
                    <i class="bi bi-eye" style="color:{{ $widgetColor }};"></i>
                    <div class="vw-stat-val" id="vw-pageviews-today">--</div>
                    <div class="vw-stat-lbl">Pages vues aujourd'hui</div>
                </div>
            </div>
            <div class="vw-stat-row">
                <div class="vw-stat-item vw-stat-full">
                    <i class="bi bi-calendar-month" style="color:{{ $widgetColor }};"></i>
                    <div class="vw-stat-val" id="vw-visitors-month">--</div>
                    <div class="vw-stat-lbl">Visiteurs ce mois</div>
                </div>
            </div>
            <div class="vw-top-pages">
                <h6><i class="bi bi-star" style="color:{{ $widgetColor }};margin-right:6px;"></i>Pages populaires</h6>
                <ul id="vw-top-pages-list">
                    <li class="vw-loading">Chargement...</li>
                </ul>
            </div>
        </div>
        <div class="vw-popup-footer" style="border-top-color:{{ $widgetColor }}20;">
            <small>Actualisation automatique toutes les 30s</small>
        </div>
    </div>
</div>

<style>
.vw-bar{cursor:pointer;padding:14px 24px;text-align:center;transition:filter .2s;user-select:none}
.vw-bar:hover{filter:brightness(1.1)}
.vw-bar-inner{display:flex;align-items:center;justify-content:center;gap:12px;max-width:600px;margin:auto}
.vw-dot{width:12px;height:12px;background:#4ade80;border-radius:50%;display:inline-block;animation:vw-pulse 1.5s infinite;box-shadow:0 0 8px rgba(74,222,128,.6);flex-shrink:0}
.vw-dot-lg{width:16px;height:16px}
@keyframes vw-pulse{0%,100%{transform:scale(1);opacity:1}50%{transform:scale(1.3);opacity:.7}}
.vw-count{font-size:2rem;font-weight:900;color:white;line-height:1}
.vw-label{font-size:1rem;font-weight:700;color:rgba(255,255,255,.95);letter-spacing:1px;text-transform:uppercase}
.vw-expand{color:rgba(255,255,255,.7);font-size:.9rem;transition:transform .3s}

.vw-floating{position:fixed;bottom:24px;right:24px;background:{{ $widgetColor }};color:white;padding:12px 18px;border-radius:50px;display:flex;align-items:center;gap:8px;cursor:pointer;box-shadow:0 4px 20px rgba(0,0,0,.25);z-index:999;transition:transform .2s,box-shadow .2s;user-select:none}
.vw-floating:hover{transform:scale(1.05);box-shadow:0 6px 25px rgba(0,0,0,.3)}
.vw-float-count{font-size:1.3rem;font-weight:900}
.vw-float-label{font-size:.85rem;font-weight:600;opacity:.9}

.vw-popup-overlay{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.5);z-index:10000;align-items:center;justify-content:center;animation:vw-fadeIn .2s}
.vw-popup-overlay.active{display:flex}
@keyframes vw-fadeIn{from{opacity:0}to{opacity:1}}
.vw-popup{background:white;border-radius:16px;width:90%;max-width:420px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.25);animation:vw-slideUp .3s;position:relative}
@keyframes vw-slideUp{from{transform:translateY(30px);opacity:0}to{transform:translateY(0);opacity:1}}
.vw-popup-close{position:absolute;top:12px;right:14px;background:rgba(255,255,255,.25);border:none;color:white;font-size:1.5rem;cursor:pointer;width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;line-height:1;z-index:1;transition:background .2s}
.vw-popup-close:hover{background:rgba(255,255,255,.4)}
.vw-popup-header{padding:28px 24px;text-align:center;color:white}
.vw-popup-online{font-size:3rem;font-weight:900;display:block;margin:8px 0 4px;line-height:1}
.vw-popup-online-label{font-size:.9rem;font-weight:700;letter-spacing:1px;text-transform:uppercase;opacity:.9}
.vw-popup-body{padding:20px 24px}
.vw-stat-row{display:flex;gap:12px;margin-bottom:12px}
.vw-stat-item{flex:1;background:#f8faf8;border-radius:12px;padding:16px 12px;text-align:center}
.vw-stat-item i{font-size:1.5rem;margin-bottom:6px;display:block}
.vw-stat-val{font-size:1.6rem;font-weight:800;color:#1f2937;line-height:1.2}
.vw-stat-lbl{font-size:.75rem;color:#6b7280;margin-top:2px}
.vw-stat-full{flex:1}
.vw-top-pages{margin-top:8px}
.vw-top-pages h6{font-size:.85rem;font-weight:700;color:#374151;margin-bottom:10px}
.vw-top-pages ul{list-style:none;padding:0;margin:0}
.vw-top-pages li{display:flex;justify-content:space-between;align-items:center;padding:8px 12px;background:#f8faf8;border-radius:8px;margin-bottom:6px;font-size:.85rem}
.vw-top-pages li .vw-page-name{color:#374151;font-weight:600;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:250px}
.vw-top-pages li .vw-page-visits{color:{{ $widgetColor }};font-weight:800;white-space:nowrap;margin-left:8px}
.vw-loading{color:#9ca3af;text-align:center;justify-content:center !important}
.vw-popup-footer{padding:12px 24px;text-align:center;background:#fafafa;border-top:1px solid}
.vw-popup-footer small{color:#9ca3af;font-size:.75rem}

@media(max-width:768px){
    .vw-count{font-size:1.5rem}
    .vw-label{font-size:.8rem;letter-spacing:.5px}
    .vw-popup{width:95%;max-width:380px}
    .vw-popup-online{font-size:2.5rem}
    .vw-stat-val{font-size:1.3rem}
    .vw-floating{bottom:16px;right:16px;padding:10px 14px}
    .vw-float-count{font-size:1.1rem}
}
</style>

<script>
var vwPopupOpen = false;
function vwTogglePopup() {
    var overlay = document.getElementById('vw-popup-overlay');
    vwPopupOpen = !vwPopupOpen;
    if (vwPopupOpen) {
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        vwFetchStats();
    } else {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }
}

function vwFetchStats() {
    fetch('{{ route("visitor.stats") }}')
        .then(function(r) { return r.json(); })
        .then(function(data) {
            var onlineEls = document.querySelectorAll('#vw-online-bar, #vw-online-float, #vw-popup-count');
            onlineEls.forEach(function(el) { if (el) el.textContent = data.online; });

            var vt = document.getElementById('vw-visitors-today');
            var pv = document.getElementById('vw-pageviews-today');
            var vm = document.getElementById('vw-visitors-month');
            if (vt) vt.textContent = data.visitors_today.toLocaleString('fr-FR');
            if (pv) pv.textContent = data.pageviews_today.toLocaleString('fr-FR');
            if (vm) vm.textContent = data.visitors_month.toLocaleString('fr-FR');

            var list = document.getElementById('vw-top-pages-list');
            if (list && data.top_pages && data.top_pages.length) {
                list.innerHTML = '';
                data.top_pages.forEach(function(p) {
                    var li = document.createElement('li');
                    li.innerHTML = '<span class="vw-page-name">' + p.page + '</span><span class="vw-page-visits">' + p.visits + ' visites</span>';
                    list.appendChild(li);
                });
            }
        })
        .catch(function() {});
}

// Auto-refresh counter every 30 seconds
setInterval(function() {
    fetch('{{ route("visitor.stats") }}')
        .then(function(r) { return r.json(); })
        .then(function(data) {
            var onlineEls = document.querySelectorAll('#vw-online-bar, #vw-online-float, #vw-popup-count');
            onlineEls.forEach(function(el) { if (el) el.textContent = data.online; });
            if (vwPopupOpen) {
                var vt = document.getElementById('vw-visitors-today');
                var pv = document.getElementById('vw-pageviews-today');
                var vm = document.getElementById('vw-visitors-month');
                if (vt) vt.textContent = data.visitors_today.toLocaleString('fr-FR');
                if (pv) pv.textContent = data.pageviews_today.toLocaleString('fr-FR');
                if (vm) vm.textContent = data.visitors_month.toLocaleString('fr-FR');
            }
        })
        .catch(function() {});
}, 30000);

// Close popup on Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && vwPopupOpen) vwTogglePopup();
});
</script>
