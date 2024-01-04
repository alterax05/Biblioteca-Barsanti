<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo $__env->yieldContent('title'); ?></title>

    <!-- Styles -->
    <link href="/favicon.ico" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="<?php echo e(URL::asset('/css/app.css')); ?>" rel="stylesheet">
    <?php echo $__env->yieldContent('style'); ?>

    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/98ad9f355f.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<body>
<div id="main">
    <div class="header">
        <div class="header-wrapper container row" style="max-width: 1200px;">
            <div class="logo col-6">
                <a href="/">
                    <img src="<?php echo e(URL::asset('/imgs/img.png')); ?>" alt="logo">
                </a>
            </div>
            <div class="col-6 d-flex">
                <div style="align-self: center;margin: 0 0 0 auto;" class="d-flex">
                    <?php if(empty(Auth()->user())): ?>
                        <a class="login" href="/login">
                            <button class="btn-primary btn">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </button>
                        </a>
                    <?php else: ?>
                        <a href="/profile" style="color: unset; text-decoration: none;">
                            <div class="profile d-flex flex-row">
                                <p><?php echo e(Auth()->user()->name . " " . Auth()->user()->surname); ?></p>
                                <div class="profile-avatar"><?php echo e(Auth()->user()->surname[0]); ?></div>
                            </div>
                        </a>

                    <?php endif; ?>
                        <a class="login" href="/faq" style="margin-left: 20px;">
                            <button class="btn-primary btn">
                                <i class="fas fa-question"></i> Domande Frequenti
                            </button>
                        </a>
                </div>
            </div>
        </div>
    </div>
    <div class="subheader">
        <div class="subheader-wrapper container row" style="max-width: 1200px;">
            <ul>
                <a href="/">
                    <li class="<?php if(Route::is('home')): ?> actived <?php endif; ?>"><i class="fas fa-home"></i> Home</li>
                </a>
                <a href="/search">
                    <li class="<?php if(Route::is('catalogo')): ?> actived <?php endif; ?>"><i class="fas fa-list"></i> Catalogo</li>
                </a>
                <a href="/autori/A">
                    <li class="<?php if(Route::is('autori')): ?> actived <?php endif; ?>"><i class="fas fa-pen-nib"></i> Autori</li>
                </a>
                <a href="/nazioni">
                    <li class="<?php if(Route::is('nazioni')): ?> actived <?php endif; ?>"><i class="fas fa-flag-usa"></i> Nazionalità</li>
                </a>
                <?php if(Auth()->user()): ?>
                <a href="/profile">
                    <li class="<?php if(Route::is('profile.*')): ?> actived <?php endif; ?>"><i class="fas fa-user"></i> Profilo</li>
                </a>
                <?php endif; ?>
                <?php if(true): ?>
                <a href="/admin">
                    <li class="<?php if(Route::is('admin')): ?> actived <?php endif; ?>"><i class="fas fa-users-cog"></i> Admin</li>
                </a>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <main class="py-4" style="padding-bottom: 0 !important; margin-bottom: 40px;">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
</div>
<footer>
    <div class="container row">
        <div class="col-8">
            <div class="d-flex flex-row">
                <img src="/imgs/img.png">
                <div class="footer-wrapper d-flex align-self-center flex-column">
                    <p>Via dei Carpani 19/B</p>
                    <p>31033 Castelfranco Veneto (TV)</p>
                    <p>tel. 0423 492847 – 493614</p>
                </div>
            </div>
        </div>
        <div class="col-4">

        </div>
    </div>
</footer>
<?php echo $__env->yieldContent('script'); ?>
</body>
</html>
<?php /**PATH /Users/edoardo/PhpstormProjects/bibliotecaLaravel/resources/views/template/layout.blade.php ENDPATH**/ ?>