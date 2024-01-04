<?php $__env->startSection('title'); ?>
    <?php if(strlen($libro->titolo) < 40): ?>
        <?php echo e($libro->titolo); ?>

    <?php else: ?>
        <?php echo e(explode('.', $libro->titolo)[0]); ?>

    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <style>

        .d-flex.medie > i {
            font-size: 26px !important;
            margin: 10px 2px;
        }

    </style>
    <div class="container row" style="margin: 0 auto; max-width: 1200px;">
        <div class="col-4">
            <img onerror="imgError(this)" style="width: 100%; border: solid 1px #c4c4c4;" src="https://pictures.abebooks.com/isbn/<?php echo e($libro->ISBN); ?>-us-300.jpg" alt="cover">
        </div>
        <div class="col-8" style="margin-bottom: 40px;">
            <div class="col-lg-12 row">
                <label style="font-size: 14px;cursor: pointer;"><a onclick="history.back();">< Torna indietro</a></label>
                <div class="col-8 dati">
                    <p><?php echo e($libro->titolo); ?></p>
                    <p>di
                        <?php $__currentLoopData = $libro->belongsAutori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $autore): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="/search/autore/<?php echo e($autore->belongsAutore->id_autore); ?>/?page=1"><?php echo e($autore->belongsAutore->autore); ?></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </p>
                    <p class="edizione"><a href="/search?editore=<?php echo e($libro->belongsEditore->id_editore); ?>&page=1"><?php echo e($libro->belongsEditore->editore); ?></a>, <?php echo e($libro->anno_stampa); ?></p>

                    <?php if(count($libro->belongsGeneri) != 0): ?>
                        <div class="genere">
                            <p>Generi:</p>
                            <div class="d-flex flex-column">
                                <?php $__currentLoopData = $libro->belongsGeneri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a style="width: fit-content;" href="/search?genere=<?php echo e($genere->belongsGenere->id_genere); ?>&page=1"><?php echo e($genere->belongsGenere->genere); ?></a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if(Auth::check()): ?>
                        <div class="d-flex" style="margin-top: 10px">
                            <div class="d-block">
                                <div class="d-flex medie">
                                    <?php for($i = 1; $i < $punteggio+1; $i++): ?>
                                        <i class="fas fa-star" punteggio="<?php echo e($i); ?>"></i>
                                    <?php endfor; ?>
                                    <?php for($i = $punteggio+1; $i < 6; $i++): ?>
                                        <i class="fas fa-star removed" punteggio="<?php echo e($i); ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-4 qrcode-prestito" style="margin-bottom: 30px;">
                    <label>Visualizza questa pagina sul telefono</label>
                    <div class="qrcode">
                        <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo e(env('APP_URL')); ?>/book/<?php echo e($libro->ISBN); ?>/&choe=UTF-8" title="Visualizzalo sul telefono" />
                    </div>
                </div>

                <div class="cc-card" style="padding: 0;margin-top: 20px;">
                    <div class="info-book">
                        <?php if($libro->descrizione != ""): ?>
                        <div class="descrizione d-flex flex-column">
                            <label><b>Descrizione</b></label>
                            <?php echo (strlen($libro->descrizione > 650)) ?substr($libro->descrizione, 0, 650) . "..." : $libro->descrizione; ?>

                        </div>
                        <?php endif; ?>
                        <div class="row col-lg-12">
                            <div class="col-5">
                                <?php if($libro->pagine != 0): ?>
                                    <p><i class="far fa-file"></i> Pagine: <b><?php echo e($libro->pagine); ?> p.</b></p>
                                <?php endif; ?>
                                <p><i class="fas fa-barcode"></i> ISBN: <b><?php echo e($libro->ISBN); ?></b></p>
                                <img class="barcode" src="/api/barcode/<?php echo e($libro->ISBN); ?>" alt="barcode">
                            </div>
                            <div class="col-7">
                                <p><i class="fas fa-language"></i> Lingua: <a href="/search?lingua=<?php echo e($libro->lingua); ?>&page=1"><b><?php echo e($libro->belongsLingua->lingua); ?></b></a></p>
                                <p><i class="fas fa-arrows-alt-v"></i> Dimensioni fisiche: <b><?php echo e($libro->altezza); ?></b></p>
                            </div>
                        </div>
                    </div>
                    <?php if(count($copie) > 0): ?>
                        <div class="col-lg-12 prestati">
                            <div class="prestato row header-table">
                                <p class="col-2">Codice identificativo</p>
                                <p class="col-3">Collocazione</p>
                                <p class="col-2">Volte prestate</p>
                                <p class="col-3">Condizioni</p>
                                <p class="col-2">Disponibilità</p>
                            </div>
                            <?php $__currentLoopData = $copie; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $copia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="prestato row riga">
                                    <p class="col-2"><?php echo e($copia->id_libro); ?> <?php if($copia->da_catalogare == 1): ?>(Provvisorio)<?php endif; ?></p>
                                    <p class="col-3" style="font-size: 13px;"><b>SCAFFALE</b> <?php echo e($copia->scaffale); ?> <b>RIP.</b> <?php echo e($copia->ripiano); ?></p>
                                    <p class="col-2"><?php echo e($copia->prestati); ?> volte</p>
                                    <p class="col-3"><?php echo e($copia->condizioni); ?></p>
                                    <?php if($copia->da_catalogare == 0): ?>
                                        <p class="col-2"><?php echo e(($copia->prestiti > 0)? "In prestito" : "Disponibile"); ?></p>
                                    <?php else: ?>
                                        <p class="col-2">Da catalogare</p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if($scheda != null): ?>
                    <div class="autori-card cc-card">

                        <div class="autori-bacheca">
                            <img class="img-autori" src="<?php echo e($scheda->avatar); ?>">
                            <div>
                                <p>Scopri <?php echo e($autore->belongsAutore->autore); ?> (<?php echo e($scheda->location); ?>)</p>
                                <a href="/search/autore/<?php echo e($autore->id_autore); ?>">Clicca per vedere tutti i titoli e la biografia</a>
                            </div>
                        </div>

                        <div class="row">
                            <?php $__currentLoopData = $libri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $libro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-3">
                                    <img onerror="imgError(this)" src="https://pictures.abebooks.com/isbn/<?php echo e($libro->ISBN); ?>-us-300.jpg">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("script"); ?>
    <script>
        function imgError(image) {
            image.onerror = "";
            image.src = "/imgs/noCover.jpg";
            return true;
        }
    </script>
    <style>
        .cc-card .info-book {
            padding: 20px 20px;
            margin-top: 20px;
        }
        .col-lg-12 .dati > p:nth-child(1) {
            font-size: 24px;
            font-weight: bold;
        }
        .col-lg-12 .dati > p:nth-child(2) {
            font-size: 14px;
            margin-bottom: 15px;
        }
        .col-lg-12 .dati > p:nth-child(3) {
            font-weight: 300;
        }
        .col-lg-12 .info-book > p:nth-child(1) {
            margin-bottom: 10px;
        }
        .col-lg-12 .info-book > div > p:nth-child(2) {
            margin-bottom: 10px;
            font-size: 50px;
            font-weight: 800;
        }
        .col-lg-12 .info-book > .row div > p{
            font-weight: 300;
        }
        .col-lg-12 .info-book > .row div:nth-child(2) > p {
            text-align: right;
        }
        .prestato.row.header-table {
            background: #f7f5f5;
            border-top: solid 1px #bfbfbf;
            margin-top: 40px;
        }
        .prestato.row {
            padding: 15px 15px;
            font-weight: 300;
            font-size: 14px;
            margin-left: 0;
            margin-right: 0;
        }
        .prestato.row > * {
            padding: 0 10px;
        }
        .edizione a {
            color: unset;
        }
        .prestato.row.header-table {
            background: #f0f0f0;
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        .prestato.row.riga:nth-child(odd) {
            background: #f4f4f4;
        }
        .qrcode-prestito {
            padding: 0;
        }
        .qrcode-prestito img {
            width: 100%;
            transform: scale(1.2);
        }
        .qrcode {
            width: 150px;
            height: 150px;
            float: right;
            overflow: hidden;
            border: solid 1px #8a8a8a;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/edoardo/PhpstormProjects/bibliotecaLaravel/resources/views/book/book.blade.php ENDPATH**/ ?>