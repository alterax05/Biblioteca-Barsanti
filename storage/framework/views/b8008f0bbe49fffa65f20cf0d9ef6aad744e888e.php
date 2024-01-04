<?php $__env->startSection('title', 'Pagine iniziale - Biblioteca'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container col-md-8" style="max-width: 1200px;">
        <div class="row">
            <div class="banner">
                <div class="banner-wrapper">
                    <h5>Adelchi</h5>
                    <p>Oltre 2.000 titoli presenti, test</p>
                    <a href="">Scopri di più</a>
                </div>
                <img src="/imgs/banner-verga.png">
            </div>
        </div>
        <div class="col-lg-12 row">
            <div class="col-4" style="margin: 25px 0;">
                <div class="cc-card categories">
                    <ul>
                        <?php $__currentLoopData = $reparti; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reparto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><i class="<?php echo e($reparto->icon); ?>"></i> <?php echo e($reparto->reparto); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
            <div class="col-8" style="padding: 0;">
                <?php $__currentLoopData = $autori_bacheca; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $autore): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="autori-card cc-card">

                        <div class="autori-bacheca">
                            <img class="img-autori" src="<?php echo e($autore->avatar); ?>">
                            <div>
                                <p>Scopri <?php echo e($autore->autore); ?> (<?php echo e($autore->location); ?>) <a href="/search/autore/<?php echo e($autore->id_autore); ?>">Vedi tutti</a></p>
                                <label><?php echo e($autore->subtitle); ?></label>
                            </div>
                        </div>

                        <div class="row">
                            <?php $__currentLoopData = $autore->libri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $libro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-3">
                                <a href="/book/<?php echo e($libro->ISBN); ?>">
                                    <img style="width: 100%;" onerror="imgError(this)" src="https://pictures.abebooks.com/isbn/<?php echo e($libro->ISBN); ?>-us-300.jpg">
                                </a>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

        </div>
        <div class="news-wrapper d-table col-lg-12">
            <div class="news float-left col-lg-4">

            </div>
        </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="/js/app.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/edoardo/PhpstormProjects/bibliotecaLaravel/resources/views/index.blade.php ENDPATH**/ ?>