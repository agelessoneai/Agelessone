
<?php $__env->startSection('content'); ?>

<style>
body{background:#0e1320;color:#e8edf6;overflow:hidden;font-family:'Segoe UI',system-ui,sans-serif}
.navbar,header{display:none!important}
.container{max-width:100%!important;margin:0!important;padding:0!important}

.app{display:grid;grid-template-columns:270px 1fr;height:100vh}
.side{background:#151b29;border-right:1px solid #262f47}
.brand{padding:18px;display:flex;gap:12px;align-items:center;border-bottom:1px solid #262f47}
.logo{width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#5b8cff,#9b6bff);display:grid;place-items:center;font-weight:800;font-size:22px;color:#fff}
.brand h1{margin:0;font-size:17px}.brand p{margin:0;font-size:11px;color:#8794ac}
.nav-title{padding:18px 24px 8px;font-size:11px;color:#8794ac;font-weight:700;letter-spacing:1px}
.nav a{display:flex;padding:14px 22px;text-decoration:none;color:#a8b4cc}
.nav a.active{background:#3f6fe0;color:#fff;border-radius:0 12px 12px 0}

.main{overflow:auto}
.top{height:76px;background:#151b29;display:flex;align-items:center;padding:0 30px;border-bottom:1px solid #262f47}
.search{width:450px;padding:13px;background:#0e1320;border:1px solid #262f47;border-radius:12px;color:#fff}
.user{margin-left:auto;display:flex;align-items:center;gap:12px}
.avatar{width:46px;height:46px;border-radius:50%;background:linear-gradient(135deg,#5b8cff,#37c281);display:grid;place-items:center;font-weight:700;color:#fff}
.logout{background:transparent;border:1px solid #334155;padding:10px 18px;color:#fff;border-radius:10px}

.content{padding:30px}
.card-dark{background:#151b29;border:1px solid #262f47;border-radius:18px;padding:25px;margin-bottom:20px}
.muted{color:#8794ac}
.btn-blue{background:#3f6fe0;color:#fff;border:0;border-radius:10px;padding:10px 16px;text-decoration:none}
.grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.label{color:#9fb3d9;font-size:12px;text-transform:uppercase;margin-bottom:6px}
.value{color:#fff;font-size:18px;font-weight:800}
.desc{color:#d7deeb;font-size:15px}
.status{display:inline-block;padding:8px 16px;border-radius:20px;background:#3f6fe0;color:#fff;font-weight:800}
.timeline{border-left:3px solid #3f6fe0;padding-left:22px;margin-left:10px}
.update{margin-bottom:25px;position:relative;background:#0e1320;border:1px solid #262f47;border-radius:14px;padding:16px}
.update:before{content:'';width:14px;height:14px;background:#3f6fe0;border-radius:50%;position:absolute;left:-31px;top:18px}
.update strong{color:#fff;font-size:16px}
.update p{color:#fff;margin:10px 0 0}
.photo{width:220px;border-radius:12px;margin-top:10px;border:1px solid #262f47}
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><?php echo e($ticket->ticket_no); ?></h2>
                    <p class="muted mb-0">Complaint ticket details and engineer updates</p>
                </div>

                <a href="<?php echo e(route('admin.tickets')); ?>" class="btn-blue">← Back to Tickets</a>
            </div>

            <div class="card-dark">
                <div class="grid">
                    <div>
                        <div class="label">Park</div>
                        <div class="value"><?php echo e($ticket->park->name); ?></div><br>

                        <div class="label">Ride / Item</div>
                        <div class="value"><?php echo e($ticket->item_name); ?></div><br>

                        <div class="label">Complaint</div>
                        <div class="value"><?php echo e($ticket->complaint_title); ?></div><br>

                        <div class="label">Description</div>
                        <div class="desc"><?php echo e($ticket->complaint_description ?? '-'); ?></div>
                    </div>

                    <div>
                        <div class="label">Assigned Engineer</div>
                        <div class="value"><?php echo e($ticket->staff->name ?? '-'); ?></div><br>

                        <div class="label">Priority</div>
                        <div class="value"><?php echo e(ucfirst($ticket->priority)); ?></div><br>

                        <div class="label">Status</div>
                        <div class="status"><?php echo e(strtoupper(str_replace('_',' ',$ticket->status))); ?></div><br><br>

                        <div class="label">Created</div>
                        <div class="value"><?php echo e($ticket->created_at->format('d M Y h:i A')); ?></div>
                    </div>
                </div>
            </div>

<div class="card-dark">

    <h3>🚗 Engineer Travel Status</h3>

    <div class="row mt-4">

        <div class="col-md-6 mb-4">
            <div class="label">👨‍🔧 Engineer</div>
            <div class="value"><?php echo e($ticket->staff->name ?? '-'); ?></div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="label">📌 Travel Status</div>

            <?php if($ticket->travel_status == 'travelling'): ?>
                <span class="status" style="background:#16a34a;">🟢 Travelling</span>
            <?php elseif($ticket->travel_status == 'arrived'): ?>
                <span class="status" style="background:#2563eb;">📍 Arrived</span>
            <?php else: ?>
                <span class="status" style="background:#6b7280;">⚪ Not Started</span>
            <?php endif; ?>
        </div>

        <div class="col-md-6 mb-4">
            <div class="label">🕒 Last Updated</div>
            <div class="value">
                <?php echo e($ticket->live_location_updated_at
                    ? \Carbon\Carbon::parse($ticket->live_location_updated_at)->format('d M Y h:i A')
                    : '-'); ?>

            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="label">🏢 Destination</div>
            <div class="value"><?php echo e($ticket->park->name); ?></div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="label">📏 Distance</div>
            <div class="value">Calculating...</div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="label">⏱ ETA</div>
            <div class="value">Calculating...</div>
        </div>

    </div>

</div>

<div class="card-dark">
    <h3>Engineer Updates</h3>

    <div class="timeline mt-4">
        <?php $__empty_1 = true; $__currentLoopData = $ticket->updates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $update): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="update">
                <strong><?php echo e(ucfirst(str_replace('_',' ',$update->update_type))); ?></strong><br>

                <small class="muted">
                    <?php echo e($update->created_at->format('d M Y h:i A')); ?>

                    by <?php echo e($update->user->name ?? '-'); ?>

                </small>

                <?php if($update->note): ?>
                    <p><?php echo e($update->note); ?></p>
                <?php endif; ?>

                <?php if($update->spare_parts): ?>
                    <div style="color:#f2b53b;font-weight:800;margin-top:10px;">
                        Required Spare Parts: <?php echo e($update->spare_parts); ?>

                    </div>
                <?php endif; ?>

                <?php if($update->image): ?>
                    <br>
                    <img class="photo" src="<?php echo e(asset('storage/'.$update->image)); ?>">
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="muted">No updates yet.</p>
        <?php endif; ?>
    </div>
</div>

<div class="card-dark">

    <h3>📍 Live Engineer Location</h3>

    <div id="map"
         style="
            width:100%;
            height:450px;
            border-radius:18px;
            overflow:hidden;
            background:#0e1320;">
    </div>

</div>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
let map = L.map('map').setView([10.0159, 76.3419], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
}).addTo(map);

let engineerMarker = null;

function loadEngineerLocation(){
    fetch("<?php echo e(route('admin.tickets.liveLocation', $ticket->id)); ?>")
        .then(response => response.json())
        .then(data => {
            if(!data.latitude || !data.longitude){
                return;
            }

            let lat = parseFloat(data.latitude);
            let lng = parseFloat(data.longitude);

            if(engineerMarker){
                engineerMarker.setLatLng([lat, lng]);
            }else{
                engineerMarker = L.marker([lat, lng]).addTo(map);
                engineerMarker.bindPopup("Engineer Location").openPopup();
                map.setView([lat, lng], 16);
            }
        });
}

loadEngineerLocation();
setInterval(loadEngineerLocation, 5000);
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Agelessone\resources\views\admin\tickets\show.blade.php ENDPATH**/ ?>