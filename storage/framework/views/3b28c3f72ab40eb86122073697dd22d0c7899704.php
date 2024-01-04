<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Sito dove visualizzare i libri presenti nella biblioteca scolastica dell'Istituto Barsanti">
    <meta name="author" content="Edoardo Roberto Ginghina">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo $__env->yieldContent('title'); ?></title>

    <!-- Styles -->
    <link href="/imgs/favicon/favicon.ico" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="<?php echo e(URL::asset('/css/app.css')); ?>" rel="stylesheet">
    <?php echo $__env->yieldContent('style'); ?>


    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>    <script src="https://kit.fontawesome.com/98ad9f355f.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link href="https://vjs.zencdn.net/7.17.0/video-js.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
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
            <div class="col-6 d-flex profile-b">
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
                                <p><?php echo e(Auth()->user()->surname . ' ' . Auth()->user()->name); ?></p>
                                <div class="profile-avatar"><?php echo e(Auth()->user()->surname[0]); ?></div>
                            </div>
                        </a>

                    <?php endif; ?>
                        <a class="propose" href="/proponi" style="color: unset; text-decoration: none;">
                            <i class="fa-solid fa-hand-holding-heart"></i>
                        </a>
                        <a class="profile-faq" href="/faq" style="color: unset; text-decoration: none;">
                            <i class="fa-solid fa-circle-question"></i>
                        </a>
                        <div class="dropdown">
                            <a class="profile-lang" type="button" id="language" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: unset; text-decoration: none;">
                                <i class="fa-solid fa-language"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="language">
                                <?php $__currentLoopData = array_keys(config('app.available_locales')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="/language/<?php echo e($lang); ?>">
                                        <button class="dropdown-item langu" type="button">
                                            <img src="https://flagcdn.com/w40/<?php echo e($lang=='en'?'gb':$lang); ?>.jpg">
                                            <span><?php echo e(config('app.available_locales')[$lang]); ?></span>
                                        </button>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="subheader navbar navbar-expand-lg sticky-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="subheader-wrapper container row collapse navbar-collapse" id="navbarText" style="max-width: 1200px;">
            <ul class="navbar-nav mr-auto">
                <a href="/" class="nav-item">
                    <li class="<?php if(Route::is('home')): ?> actived <?php endif; ?>"><i class="fa-solid fa-house-user"></i> <?php echo e(__('home.home')); ?></li>
                </a>
                <a href="/search" class="nav-item">
                    <li class="<?php if(Route::is('catalogo.*')): ?> actived <?php endif; ?>"><i class="fas fa-list"></i> <?php echo e(__('home.catalogo')); ?></li>
                </a>
                <a href="/autori/A" class="nav-item">
                    <li class="<?php if(Route::is('autori')): ?> actived <?php endif; ?>"><i class="fas fa-pen-nib"></i> <?php echo e(__('home.autori')); ?></li>
                </a>
                <a href="/nazioni" class="nav-item">
                    <li class="<?php if(Route::is('nazioni')): ?> actived <?php endif; ?>"><i class="fas fa-flag-usa"></i> <?php echo e(__('home.nazionalità')); ?></li>
                </a>
                <?php if(Auth()->user()): ?>
                <a href="/profile" class="nav-item">
                    <li class="<?php if(Route::is('profile.*')): ?> actived <?php endif; ?>"><i class="fas fa-user"></i> <?php echo e(__('home.profilo')); ?></li>
                </a>
                <?php endif; ?>
                <?php if(Auth()->check() && Auth()->user()->isAdmin()): ?>
                <a href="/admin">
                    <li class="<?php if(Route::is('admin.*')): ?> actived <?php endif; ?>"><i class="fas fa-users-cog"></i> Admin</li>
                </a>
                <?php endif; ?>
            </ul>
        </div>
        <div class="mobile-menu">

        </div>
    </nav>
    <main class="py-4" style="padding-bottom: 0 !important; margin-bottom: 40px;">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
</div>
<footer>
    <div class="container row" style="margin: 20px auto;">
        <div class="col-6 brands">
            <div class="d-flex flex-row">
                <i class="fa-brands fa-laravel"></i>
                <i class="fa-brands fa-vuejs"></i>
                <label style="max-width: 240px;"><?php echo e(__('footer.created')); ?> <a href="https://laravel.com/"><?php echo e(__('footer.laravel')); ?></a> <?php echo e(__('footer.e')); ?> <a href="https://vuejs.org/"><?php echo e(__('footer.vuejs')); ?></a></label>
            </div>
        </div>
        <div class="col-6 copyright">
            <div>
                <a href="http://creativecommons.org/licenses/by-sa/4.0/" rel="license" style="text-decoration: none">
                    <div class="d-flex flex-row-reverse">
                        <i class="fa-brands fa-creative-commons-sa"></i>
                        <i class="fa-brands fa-creative-commons-by"></i>
                        <i class="fa-brands fa-creative-commons"></i>
                    </div>
                    <div style="text-align: right">
                        <label><?php echo e(__('footer.copyright')); ?></label>
                    </div>
                </a>
                <label style="margin-top: 20px;"><?php echo e(__('footer.cre')); ?> <b>Ginghina Edoardo</b> <?php echo e(__('footer.cre2')); ?><b>IT Team</b></label>
                <label><?php echo e(__('footer.copyright_lang')); ?></label>
            </div>
        </div>
    </div>
</footer>
<?php echo $__env->yieldContent('script'); ?>
</body>
</html>
<?php /**PATH C:\Users\mikyp\Downloads\backup_biblioteca.barsanti.edu.it\httpdocs\resources\views/template/layout.blade.php ENDPATH**/ ?>