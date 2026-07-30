<?php $__env->startSection('content'); ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

*{
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

html,
body{
    margin:0 !important;
    padding:0 !important;
    width:100%;
    min-height:100%;
    background:#070d1a !important;
    overflow:hidden !important;
}

.navbar,
header{
    display:none !important;
}

.container,
.container-fluid{
    max-width:100% !important;
    width:100% !important;
    margin:0 !important;
    padding:0 !important;
}

.login-page{
    height:100vh;
    width:100vw;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:18px;
    background:
        radial-gradient(circle at 0% 100%, rgba(124,58,237,.45), transparent 28%),
        radial-gradient(circle at 100% 0%, rgba(37,99,235,.38), transparent 28%),
        linear-gradient(135deg,#050914,#080f22 45%,#0d1230);
    color:#fff;
    overflow:hidden;
}

.login-wrap{
    width:100%;
    max-width:520px;
    text-align:center;
    transform:scale(.88);
}

.logo{
    width:74px;
    height:74px;
    border-radius:18px;
    background:linear-gradient(135deg,#4f7cff,#7c3aed);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:30px;
    font-weight:800;
    margin:0 auto 14px;
    box-shadow:0 18px 45px rgba(124,58,237,.35);
}

.brand-title{
    font-size:34px;
    font-weight:800;
    margin:0;
    color:#fff;
}

.brand-subtitle{
    color:#9aa6c4;
    letter-spacing:6px;
    font-size:14px;
    margin-top:6px;
    margin-bottom:24px;
}

.login-card{
    background:rgba(15,23,42,.78);
    border:1px solid rgba(148,163,184,.22);
    border-radius:24px;
    padding:30px 36px;
    text-align:left;
    box-shadow:0 30px 90px rgba(0,0,0,.55);
    backdrop-filter:blur(18px);
}

.login-card h3{
    text-align:center;
    font-size:28px;
    font-weight:800;
    margin:0;
    color:#fff;
}

.login-card .desc{
    text-align:center;
    color:#a6b0cf;
    margin:8px 0 26px;
    font-size:15px;
}

.form-label{
    color:#fff;
    font-weight:600;
    margin-bottom:8px;
}

.form-control{
    height:50px;
    border-radius:12px;
    background:#141d31 !important;
    border:1px solid #334155;
    color:#fff !important;
    padding:0 16px;
    font-size:15px;
}

.form-control::placeholder{
    color:#6f7b99;
}

.form-control:focus{
    border-color:#6366f1;
    box-shadow:0 0 0 4px rgba(99,102,241,.18);
}

.btn-register{
    height:54px;
    border-radius:14px;
    border:0;
    color:#fff;
    font-size:17px;
    font-weight:700;
    background:linear-gradient(90deg,#4f7cff,#7c3aed);
}

.btn-register:hover{
    color:#fff;
    transform:translateY(-1px);
}

.login-link{
    color:#8b5cf6;
    text-decoration:none;
    font-weight:600;
}

@media(max-height:760px){
    .login-wrap{
        transform:scale(.78);
    }
}

@media(max-width:600px){
    .login-wrap{
        transform:scale(.92);
    }

    .login-card{
        padding:24px 20px;
    }

    .brand-title{
        font-size:30px;
    }
}
</style>

<div class="login-page">
    <div class="login-wrap">

        <div class="logo">A1</div>

        <h1 class="brand-title">Ageless One</h1>
        <div class="brand-subtitle">AI BUSINESS SUITE</div>

        <div class="login-card">

            <h3>Create Account</h3>
            <div class="desc">Register your Ageless One user account</div>

            <form method="POST" action="<?php echo e(route('register.post')); ?>">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input
                        name="name"
                        value="<?php echo e(old('name')); ?>"
                        class="form-control"
                        placeholder="Enter your full name"
                        required>

                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input
                        type="email"
                        name="email"
                        value="<?php echo e(old('email')); ?>"
                        class="form-control"
                        placeholder="Enter your email address"
                        required>

                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Enter your password"
                        required>

                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-4">
                    <label class="form-label">Confirm Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Confirm your password"
                        required>
                </div>

                <button class="btn btn-register w-100" type="submit">
                    Create User Account
                </button>

            </form>

            <p class="text-center mt-4 mb-0 text-light">
                Already have an account?
                <a href="<?php echo e(route('login')); ?>" class="login-link">Back to login</a>
            </p>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ageless-admin-panel\resources\views\auth\register.blade.php ENDPATH**/ ?>