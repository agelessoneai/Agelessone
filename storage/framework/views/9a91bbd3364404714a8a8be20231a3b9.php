<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ageless One Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root{
            --bg:#07101f;
            --panel:#0f172a;
            --panel-soft:#111c33;
            --border:#24324b;
            --text:#f8fafc;
            --muted:#93a4bf;
            --primary:#2563eb;
            --primary-light:#3b82f6;
        }

        *{
            box-sizing:border-box;
        }

        html,body{
            margin:0;
            min-height:100%;
            font-family:'Poppins',sans-serif;
            background:var(--bg);
            color:var(--text);
        }

        body{
            min-height:100vh;
        }

        .home-page{
            min-height:100dvh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:24px 16px;
            background:
                radial-gradient(circle at 12% 88%, rgba(37,99,235,.18), transparent 30%),
                radial-gradient(circle at 88% 12%, rgba(59,130,246,.12), transparent 28%),
                linear-gradient(145deg,#06101f,#0a1427 52%,#0b1630);
        }

        .home-card{
            width:min(100%, 920px);
            display:grid;
            grid-template-columns:1fr 1fr;
            overflow:hidden;
            border:1px solid var(--border);
            border-radius:24px;
            background:rgba(15,23,42,.95);
            box-shadow:0 28px 80px rgba(0,0,0,.42);
        }

        .home-intro{
            padding:48px 42px;
            display:flex;
            flex-direction:column;
            justify-content:center;
            background:
                linear-gradient(145deg,rgba(37,99,235,.20),rgba(15,23,42,.96)),
                #0f172a;
            border-right:1px solid var(--border);
        }

        .logo{
            width:62px;
            height:62px;
            border-radius:16px;
            display:flex;
            align-items:center;
            justify-content:center;
            margin-bottom:20px;
            background:linear-gradient(135deg,var(--primary-light),var(--primary));
            color:#fff;
            font-size:25px;
            font-weight:700;
            box-shadow:0 14px 35px rgba(37,99,235,.25);
        }

        .home-intro h1{
            margin:0;
            font-size:34px;
            line-height:1.2;
            font-weight:700;
        }

        .home-intro p{
            margin:14px 0 0;
            color:var(--muted);
            font-size:15px;
            line-height:1.75;
        }

        .brand-note{
            margin-top:24px;
            color:#7fa8ef;
            letter-spacing:3px;
            font-size:11px;
            font-weight:600;
        }

        .login-section{
            padding:40px 36px;
            display:flex;
            align-items:center;
        }

        .login-form{
            width:100%;
        }

        .login-form h2{
            margin:0;
            text-align:center;
            font-size:27px;
            font-weight:700;
        }

        .login-form .desc{
            margin:7px 0 24px;
            text-align:center;
            color:var(--muted);
            font-size:14px;
        }

        .form-group{
            margin-bottom:17px;
        }

        .form-label{
            display:block;
            margin-bottom:7px;
            color:#eaf0fb;
            font-size:13px;
            font-weight:600;
        }

        .form-control{
            width:100%;
            min-height:48px;
            padding:12px 14px;
            border:1px solid #31415f;
            border-radius:11px;
            outline:none;
            background:var(--panel-soft);
            color:#fff;
            font-size:15px;
        }

        .form-control::placeholder{
            color:#71819e;
        }

        .form-control:focus{
            border-color:var(--primary-light);
            box-shadow:0 0 0 3px rgba(59,130,246,.14);
        }

        .remember-row{
            margin:2px 0 18px;
            display:flex;
            align-items:center;
        }

        .remember-row input{
            width:18px;
            height:18px;
            margin:0;
            accent-color:var(--primary);
        }

        .remember-row label{
            margin-left:8px;
            color:#d7e0ef;
            font-size:13px;
        }

        .login-button{
            width:100%;
            min-height:49px;
            border:0;
            border-radius:11px;
            cursor:pointer;
            background:linear-gradient(90deg,var(--primary),var(--primary-light));
            color:#fff;
            font-size:15px;
            font-weight:700;
            transition:.2s ease;
        }

        .login-button:hover{
            transform:translateY(-1px);
            box-shadow:0 12px 28px rgba(37,99,235,.28);
        }

        .error-text{
            display:block;
            margin-top:6px;
            color:#f87171;
            font-size:12px;
        }

        .footer-note{
            margin-top:18px;
            text-align:center;
            color:#71819e;
            font-size:12px;
        }

        @media(max-width:768px){
            .desktop-only-text{
                display:none;
            }

            .home-page{
                align-items:flex-start;
                padding:16px 12px;
            }

            .home-card{
                grid-template-columns:1fr;
                border-radius:18px;
            }

            .home-intro{
                padding:26px 22px;
                border-right:0;
                border-bottom:1px solid var(--border);
                text-align:center;
                align-items:center;
            }

            .logo{
                width:54px;
                height:54px;
                margin-bottom:14px;
                font-size:22px;
            }

            .home-intro h1{
                font-size:25px;
            }

            .home-intro p{
                font-size:13px;
                line-height:1.6;
            }

            .brand-note{
                margin-top:14px;
            }

            .login-section{
                padding:26px 20px;
            }

            .login-form h2{
                font-size:23px;
            }

            .form-control{
                min-height:46px;
                font-size:16px;
            }
        }

        @media(min-width:1024px){
            .home-page{
                padding: 0;
            }
            .home-card{
                width: 100%;
                max-width: 100%;
                min-height: 100vh;
                border-radius: 0;
                border: 0;
            }
            .login-form{
                max-width: 440px;
                margin: 0 auto;
            }
            .home-intro{
                padding: 60px 80px;
            }
        }

        @media(max-width:380px){
            .home-intro{
                padding:22px 16px;
            }

            .login-section{
                padding:22px 16px;
            }
        }
    </style>
</head>
<body>

<div class="home-page">
    <div class="home-card">

        <section class="home-intro">
            <div class="logo">A1</div>
            <h1>Ageless One</h1>
            <p class="desktop-only-text">
                Manage work sites, attendance, security, workers,
                inventory and daily operations from one platform.
            </p>
            <div class="brand-note">AI BUSINESS SUITE</div>
        </section>

        <section class="login-section">
            <div class="login-form">
                <h2>Welcome Back</h2>
                <div class="desc">Sign in to continue</div>

                <form method="POST" action="<?php echo e(route('login.post')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="form-group">
                        <label class="form-label" for="login">Email or Phone Number</label>
                        <input
                            id="login"
                            type="text"
                            name="login"
                            value="<?php echo e(old('login')); ?>"
                            class="form-control"
                            placeholder="Enter your email or phone number"
                            autocomplete="username"
                            required
                            autofocus
                        >
                        <?php $__errorArgs = ['login'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="error-text"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="error-text"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="remember-row">
                        <input
                            type="checkbox"
                            name="remember"
                            id="remember"
                            value="1"
                            <?php echo e(old('remember') ? 'checked' : ''); ?>

                        >
                        <label for="remember">Remember me</label>
                    </div>

                    <button type="submit" class="login-button">
                        Login
                    </button>
                </form>

                <div class="footer-note">
                    Ageless One ERP · Secure Access
                </div>
            </div>
        </section>

    </div>
</div>                                                         
       </html><?php /**PATH C:\Agelessone\resources\views/auth/login.blade.php ENDPATH**/ ?>