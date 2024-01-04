<?php $__env->startSection('title'); ?>
    <?php echo e(__('home.title')); ?> - Biblioteca
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container col-md-9 col-lg-12 col-9" style="max-width: 1200px;">
        <div class="col-lg-12 row">
            <div class="col-4">
                <div class="cc-card categories">
                    <ul>
                        <li><?php echo e(__('home.cataloghi')); ?></li>
                        <?php $__currentLoopData = $reparti; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reparto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="/search/sezione/<?php echo e($reparto->id_reparto); ?>">
                                <li><i class="<?php echo e($reparto->icon); ?>"></i> <?php echo e(__('categorie.' . $reparto->reparto)); ?> (<?php echo e($reparto->numeri??0); ?>)</li>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
            <div class="col-8" style="padding: 0;">
                <div id="banner" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php for($i = 0; $i < count($carousel); $i++): ?>
                            <li data-target="#banner" data-slide-to="<?php echo e($i); ?>" class="active"></li>
                        <?php endfor; ?>
                    </ol>
                    <div class="carousel-inner">
                        <?php for($i = 0; $i < count($carousel); $i++): ?>
                        <div class="carousel-item <?php echo e(($i == 0)?'active':''); ?>">
                            <div class="banner">
                                <div class="banner-wrapper">
                                    <h5><?php echo e($carousel[$i]->title); ?></h5>
                                    <p><?php echo $carousel[$i]->subtitle; ?></p>
                                    <?php if($carousel[$i]->autore != null): ?>
                                        <a href="/search/autore/<?php echo e($carousel[$i]->autore); ?>"><?php echo e(__('home.more')); ?></a>
                                    <?php endif; ?>
                                </div>
                                <img src="<?php echo e($carousel[$i]->image); ?>">
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                    <a class="carousel-control-prev" href="#banner" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Indietro</span>
                    </a>
                    <a class="carousel-control-next" href="#banner" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Avanti</span>
                    </a>
                </div>

                <?php $__currentLoopData = $autori_bacheca; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $autore): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="autori-card cc-card">

                        <div class="autori-bacheca">
                            <img class="img-autori" src="/imgs/authors/<?php echo e($autore->id_autore); ?>.jpg">
                            <div>
                                <p><?php echo e(__('home.discover')); ?> <?php echo e($autore->autore); ?> (<?php echo e($autore->location); ?>) <a href="/search/autore/<?php echo e($autore->id_autore); ?>"><?php echo e(__('home.more')); ?></a></p>
                                <label><?php echo e($autore->subtitle); ?></label>
                            </div>
                        </div>

                        <div class="row">
                            <?php $__currentLoopData = $autore->libri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $libro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-3">
                                <a href="/book/<?php echo e($libro->ISBN); ?>">
                                    <img style="width: 100%;" onerror="imgError(this)" src="/imgs/covers/<?php echo e($libro->ISBN); ?>.jpg">
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

<?php echo $__env->make('template.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mikyp\Downloads\backup_biblioteca.barsanti.edu.it\httpdocs\resources\views/index.blade.php ENDPATH**/ ?>