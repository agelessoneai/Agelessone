

<?php $__env->startSection('content'); ?>

<?php
$user = Auth::user();
$initials = strtoupper(substr($user->name,0,1));
?>

<style>
:root{
    --bg:#0e1320;
    --card:#151b29;
    --card2:#1c2436;
    --line:#262f47;
    --text:#e8edf6;
    --muted:#8794ac;
    --blue:#3f6fe0;
    --purple:#9b6bff;
    --green:#37c281;
    --red:#ff5a6e;
    --orange:#f2b53b;
}
body{margin:0;background:var(--bg);color:var(--text);font-family:'Segoe UI',system-ui,sans-serif}
.navbar,header{display:none!important}
.mobile-app-shell { max-width: 100% !important; margin: 0 !important; border-radius: 0 !important; border: 0 !important; min-height: 100vh !important; }
.app-content { padding: 0 !important; }
.container{max-width:100%!important;padding:0!important;margin:0!important}
.full-wrapper {
    min-height: 100vh;
    padding: 18px;
    padding-bottom: 92px;
    background: var(--bg);
}
.left-panel {
    background: radial-gradient(circle at top right,rgba(91,140,255,.25),transparent 30%),radial-gradient(circle at bottom left,rgba(155,107,255,.22),transparent 30%),var(--bg);
    border-radius: 24px;
    padding: 18px;
}
.right-panel {
    margin-top: 24px;
}
.desktop-title { display: none; }
.app-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:22px}
.profile{display:flex;align-items:center;gap:12px}
.avatar{width:48px;height:48px;border-radius:16px;background:linear-gradient(135deg,var(--blue),var(--purple));display:grid;place-items:center;font-weight:800;font-size:18px}
.profile h3{font-size:18px;margin:0}.profile p{margin:2px 0 0;color:var(--muted);font-size:12px}
.logout{background:var(--card);border:1px solid var(--line);color:var(--text);border-radius:14px;padding:10px 14px;font-size:13px;transition:.2s}
.logout:hover{background:var(--card2)}
.attendance-card{background:var(--card);border:1px solid var(--line);border-radius:24px;padding:22px;margin-bottom:22px}
.attendance-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px}
.attendance-head h3{font-size:18px;margin:0}
.status-pill{padding:6px 12px;border-radius:999px;font-size:12px;font-weight:700}
.status-out{background:rgba(255,90,110,.15);color:var(--red)}
.status-in{background:rgba(55,194,129,.15);color:var(--green)}
.status-done{background:rgba(63,111,224,.18);color:#8fb0ff}
.punch-btn{width:100%;border:0;border-radius:18px;padding:17px;font-size:16px;font-weight:800;color:#fff}
.punch-in{background:linear-gradient(135deg,var(--green),#22c55e)}
.punch-out{background:linear-gradient(135deg,var(--red),#ef4444)}
.photo-label{font-size:12px;font-weight:700;color:var(--muted);letter-spacing:.5px;margin-bottom:8px;margin-top:4px}
.photo-input{width:100%;background:var(--card2);border:1px solid var(--line);color:var(--text);border-radius:14px;padding:10px 12px;font-size:13px;margin-bottom:6px;box-sizing:border-box}
.photo-input::file-selector-button{background:var(--blue);color:#fff;border:0;border-radius:10px;padding:6px 14px;font-size:12px;font-weight:700;cursor:pointer;margin-right:10px}
.photo-hint{font-size:11px;color:var(--muted);margin-bottom:14px}
.done-box{background:rgba(55,194,129,.1);border:1px solid rgba(55,194,129,.25);border-radius:18px;padding:16px;color:#c9ffe2}
.time-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:12px;margin-top:14px}
.time-item{background:var(--card2);border-radius:16px;padding:14px}
.time-item span{display:block;color:var(--muted);font-size:12px;margin-bottom:4px}
.time-item b{font-size:15px}
.alert-success{background:rgba(55,194,129,.12);border:1px solid rgba(55,194,129,.3);color:#c9ffe2;border-radius:16px;padding:12px;margin-bottom:15px;font-size:13px}
.quick-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:14px;margin-bottom:22px}
.quick-card{background:var(--card);border:1px solid var(--line);border-radius:22px;padding:18px}
.quick-card .icon{width:42px;height:42px;border-radius:14px;background:var(--card2);display:grid;place-items:center;font-size:20px;margin-bottom:14px}
.quick-card h4{font-size:15px;margin:0 0 4px}.quick-card p{font-size:12px;color:var(--muted);margin:0}
.bottom-nav{position:fixed;left:12px;right:12px;bottom:12px;background:rgba(21,27,41,.95);border:1px solid var(--line);border-radius:24px;display:grid;grid-template-columns:repeat(4,1fr);padding:10px 6px;backdrop-filter:blur(16px)}
.bottom-nav a{text-align:center;color:var(--muted);text-decoration:none;font-size:11px}.bottom-nav a.active{color:#fff}.bottom-nav i{display:block;font-style:normal;font-size:20px;margin-bottom:3px}

@media(min-width:1024px){
    .full-wrapper {
        display: grid;
        grid-template-columns: 450px 1fr;
        gap: 24px;
        padding: 24px;
        align-items: start;
        background: var(--bg);
        min-height: 100vh;
    }
    .left-panel {
        padding: 24px;
        border: 1px solid var(--line);
        border-radius: 24px;
        min-height: calc(100vh - 48px);
    }
    .right-panel {
        background: radial-gradient(circle at top left,rgba(91,140,255,.05),transparent 40%), var(--bg);
        border: 1px solid var(--line);
        border-radius: 24px;
        padding: 32px;
        margin-top: 0;
        min-height: calc(100vh - 48px);
    }
    .desktop-title {
        display: block;
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 24px;
    }
    .quick-grid {
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }
    .bottom-nav {
        max-width: 500px;
        margin: auto;
        left: 0;
        right: 0;
        bottom: 24px;
    }
}

.punch-btn.loading{
    opacity:.9;
    pointer-events:none;
}
.punch-btn.loading::after{
    content:"";
    width:18px;
    height:18px;
    border:3px solid rgba(255,255,255,.35);
    border-top-color:#fff;
    border-radius:50%;
    display:inline-block;
    margin-left:10px;
    vertical-align:middle;
    animation:spin .8s linear infinite;
}
@keyframes spin{
    to{transform:rotate(360deg)}
}
#appLoader{
    position:fixed;
    inset:0;
    background:#0e1320;
    display:flex;
    align-items:center;
    justify-content:center;
    z-index:999999;
}
.loader-box{
    text-align:center;
}
.logo-circle{
    width:90px;
    height:90px;
    margin:auto;
    border-radius:24px;
    background:linear-gradient(135deg,#5b8cff,#9b6bff);
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-size:34px;
    font-weight:800;
    animation:logoFloat 1.4s infinite ease-in-out;
}
.loader-box h2{
    margin-top:25px;
    color:#fff;
    font-size:28px;
    font-weight:800;
}
.loader-box p{
    color:#8c96aa;
    margin-top:8px;
    letter-spacing:2px;
}
.loading-bar{
    width:240px;
    height:7px;
    margin:35px auto 0;
    background:#20283b;
    border-radius:20px;
    overflow:hidden;
}
.loading-progress{
    height:100%;
    width:0%;
    background:linear-gradient(90deg,#5b8cff,#37c281);
    animation:loading 2s linear forwards;
}
@keyframes loading{
    from{width:0%;}
    to{width:100%;}
}
@keyframes logoFloat{
    0%{transform:translateY(0);}
    50%{transform:translateY(-10px);}
    100%{transform:translateY(0);}
}
</style>

<div class="full-wrapper">

    <div class="left-panel">
        <div class="app-header">
            <div class="profile">
                <div class="avatar"><?php echo e($initials); ?></div>
                <div>
                    <h3><?php echo e($user->name); ?></h3>
                    <p>Staff Member</p>
                </div>
            </div>

            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button class="logout">Logout</button>
            </form>
        </div>

        <div class="attendance-card">

            <div class="attendance-head">
                <h3>Today Attendance</h3>

                <?php if(!$attendance): ?>
                    <span class="status-pill status-out">Not Punched</span>
                <?php elseif($attendance && !$attendance->punch_out): ?>
                    <span class="status-pill status-in">In Office</span>
                <?php else: ?>
                    <span class="status-pill status-done">Completed</span>
                <?php endif; ?>
            </div>

            <?php if(session('success')): ?>
                <div class="alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>


            <?php if(!$attendance): ?>

              <form id="punchInForm" method="POST" action="<?php echo e(route('attendance.punchin')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="location" id="in_location">

        <div class="photo-label">📷 PHOTO VERIFICATION (REQUIRED)</div>
        <input type="file" name="photo" id="punchInPhoto" accept="image/*" capture="environment" required class="photo-input">
        <div id="punchInPhotoName" class="photo-hint">No photo selected</div>

       <button id="punchInBtn" class="punch-btn punch-in" type="button" onclick="getPunchLocation('in')">
        🟢 Punch In
    </button>
    </form>

            <?php elseif($attendance && !$attendance->punch_out): ?>

                <div class="time-grid">
                    <div class="time-item">
                        <span>Punch In</span>
                        <b><?php echo e(\Carbon\Carbon::parse($attendance->punch_in)->format('h:i A')); ?></b>
                    </div>

                    <div class="time-item">
                        <span>Status</span>
                        <b style="color:var(--green)">Working</b>
                    </div>
                </div>

                <br>

             <form id="punchOutForm" method="POST" action="<?php echo e(route('attendance.punchout')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="location" id="out_location">

        <div class="photo-label">📷 PHOTO VERIFICATION (OPTIONAL)</div>
        <input type="file" name="photo" id="punchOutPhoto" accept="image/*" capture="environment" class="photo-input">
        <div id="punchOutPhotoName" class="photo-hint">No photo selected</div>

       <button id="punchOutBtn" class="punch-btn punch-out" type="button" onclick="getPunchLocation('out')">
        🔴 Punch Out
    </button>
    </form>

            <?php else: ?>

                <div class="done-box">
                    <strong>Attendance Completed</strong>

                    <div class="time-grid">
                        <div class="time-item">
                            <span>Punch In</span>
                            <b><?php echo e(\Carbon\Carbon::parse($attendance->punch_in)->format('h:i A')); ?></b>
                        </div>

                        <div class="time-item">
                            <span>Punch Out</span>
                            <b><?php echo e(\Carbon\Carbon::parse($attendance->punch_out)->format('h:i A')); ?></b>
                        </div>

                        <div class="time-item">
                            <span>Total Time</span>
                            <b>
                                <?php echo e(floor($attendance->total_minutes / 60)); ?>h
                                <?php echo e($attendance->total_minutes % 60); ?>m
                            </b>
                        </div>

                        <div class="time-item">
                            <span>Status</span>
                            <b style="color:var(--green)">Present</b>
                        </div>
                    </div>
                </div>

            <?php endif; ?>

        </div>
    </div>

    <div class="right-panel">
        <div class="desktop-title">Quick Actions</div>
        <div class="quick-grid">
            <div class="quick-card"><div class="icon">👤</div><h4>My Profile</h4><p>View account details</p></div>
            <a href="<?php echo e(route('staff.tickets')); ?>" class="quick-card" style="text-decoration:none;color:inherit"><div class="icon">🎫</div><h4>My Tickets</h4><p>View assigned tickets</p></a>
            <a href="<?php echo e(route('staff.daily-updates')); ?>" class="quick-card" style="text-decoration:none;color:inherit"><div class="icon">📋</div><h4>Daily Updates</h4><p>Post site work updates</p></a>
            <a href="<?php echo e(route('expenses.my')); ?>" class="quick-card" style="text-decoration:none;color:inherit"><div class="icon">🧾</div><h4>My Expenses</h4><p>Add bills and expenses</p></a>
            <?php if(in_array(auth()->user()->role, ['site_supervisor', 'site_manager', 'project_manager', 'project_coordinator', 'project_head'])): ?>
            <?php
                $wagesRoute = in_array(auth()->user()->role, ['site_supervisor'])
                    ? route('supervisor.wages.create')
                    : route('admin.wages.create');
            ?>
            <a href="<?php echo e($wagesRoute); ?>" class="quick-card" style="text-decoration:none;color:inherit"><div class="icon">💰</div><h4>Worker Wages</h4><p>Manage worker wages</p></a>
            <?php endif; ?>
        </div>
    </div>

</div>

<!--loader -->
<div id="appLoader">
    <div class="loader-box">
        <div class="logo-circle">
            <span>A1</span>
        </div>
        <h2>Ageless One</h2>
        <p>AI Business Suite</p>
        <div class="loading-bar">
            <div class="loading-progress"></div>
        </div>
    </div>
</div> 
<!--loader end -->

<div class="bottom-nav">
    <a href="#" class="active"><i>🏠</i>Home</a>
    <a href="<?php echo e(route('staff.tickets')); ?>"
       class="<?php echo e(request()->routeIs('staff.tickets') ? 'active' : ''); ?>">
        <i>🎫</i>My Tickets
    </a>
    <a href="<?php echo e(route('staff.daily-updates')); ?>" class="<?php echo e(request()->routeIs('staff.daily-updates') ? 'active' : ''); ?>"><i>📋</i>Updates</a>
    <a href="<?php echo e(route('expenses.my')); ?>" class="<?php echo e(request()->routeIs('expenses.*') ? 'active' : ''); ?>"><i>🧾</i>Expenses</a>
</div>

<script>
async function getPunchLocation(type){

    let btn = type === "in"
        ? document.getElementById("punchInBtn")
        : document.getElementById("punchOutBtn");

    // Validate photo is selected on punch-in (mandatory)
    if (type === "in") {
        const photoInput = document.getElementById("punchInPhoto");
        if (!photoInput || !photoInput.files || photoInput.files.length === 0) {
            alert("📷 Photo verification is required. Please take or select a photo before punching in.");
            return;
        }
    }

    btn.classList.add("loading");
    btn.innerHTML = type === "in" ? "Punching In" : "Punching Out";

    if(!navigator.geolocation){
        alert("Location not supported on this device.");
        resetPunchButton(type, btn);
        return;
    }

    navigator.geolocation.getCurrentPosition(async function(position){

        let lat = position.coords.latitude;
        let lon = position.coords.longitude;
        let place = "Unknown Location";

        btn.innerHTML = "Getting Location";

        try{
            let response = await fetch(
                "https://nominatim.openstreetmap.org/reverse?format=json&lat=" + lat + "&lon=" + lon
            );

            let data = await response.json();

            place =
                data.address.suburb ||
                data.address.neighbourhood ||
                data.address.city ||
                data.address.town ||
                data.address.village ||
                data.display_name ||
                "Unknown Location";

        }catch(e){
            place = "Unknown Location";
        }

        btn.innerHTML = "Saving";

        if(type === "in"){
            document.getElementById("in_location").value = place;
            document.getElementById("punchInForm").submit();
        }else{
            document.getElementById("out_location").value = place;
            document.getElementById("punchOutForm").submit();
        }

    }, function(){
        alert("Please allow location permission to punch.");
        resetPunchButton(type, btn);
    });
}

function resetPunchButton(type, btn){
    btn.classList.remove("loading");
    btn.innerHTML = type === "in" ? "🟢 Punch In" : "🔴 Punch Out";
}

// Show selected file name
document.addEventListener('DOMContentLoaded', function(){
    const inPhoto = document.getElementById('punchInPhoto');
    const outPhoto = document.getElementById('punchOutPhoto');

    if (inPhoto) {
        inPhoto.addEventListener('change', function(){
            const hint = document.getElementById('punchInPhotoName');
            hint.textContent = this.files.length ? '✅ ' + this.files[0].name : 'No photo selected';
            hint.style.color = this.files.length ? 'var(--green)' : 'var(--muted)';
        });
    }

    if (outPhoto) {
        outPhoto.addEventListener('change', function(){
            const hint = document.getElementById('punchOutPhotoName');
            hint.textContent = this.files.length ? '✅ ' + this.files[0].name : 'No photo selected';
            hint.style.color = this.files.length ? 'var(--green)' : 'var(--muted)';
        });
    }
});
</script>
<script>
window.addEventListener("load",function(){

    setTimeout(function(){
        let loader = document.getElementById("appLoader");
        if(loader){
            loader.style.opacity="0";
            loader.style.transition="0.5s";
            setTimeout(function(){
                loader.remove();
            },500);
        }
    },2000);

});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Agelessone\resources\views/user/dashboard.blade.php ENDPATH**/ ?>