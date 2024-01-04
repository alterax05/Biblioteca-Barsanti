<?php $__env->startSection('title'); ?>
        Ricerca tra i libri - Biblioteca
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container row" style="margin: 0 auto; max-width: 1200px;">

        <label><a href="/">< Torna alla homepage</a></label>

        <div class="col-4">
                <div class="cc-card filter-card" style="margin-bottom: 20px;">
                    <div class="d-table" style="width: 100%">
                        <p>Filtri</p>

                        <?php $__currentLoopData = array_keys($_GET); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(in_array($key, ['editore', 'genere', 'lingua', 'autore', 'anno', 'query'])): ?>
                            <div class="filter">
                                <a href="<?php echo e(preg_replace('/([?&])page=[^&]+(&|$)/','$1', preg_replace('/([?&])'. $key .'=[^&]+(&|$)/','$1', $url))); ?>" style="text-decoration: none; color: unset;">
                                    <span><?php echo e($key); ?> <label class="close">+</label></span>
                                </a>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

            <div class="cc-card">
                <!--
                <div class="filter-card">
                    <p>Scaffale</p>
                    <div style="margin-top: 10px">
                        <form method="GET" id="scaffaleForm">
                            <select @change="scaffale" name="scaffale" class="form-select" style="width: 100%">
                                <option value="">Scegli uno scaffale</option>

                            </select>
                            <input type="hidden" name="page" value="1">
                        </form>
                    </div>
                </div>
                -->
                <?php if(empty($_GET['autore']) && count($autori) != 0): ?>
                    <div class="filter-card">
                        <p>Autori</p>
                        <ul>
                            <?php $__currentLoopData = $autori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $autore): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e($url . ((!$_GET)? '?':'&')); ?>autore=<?php echo e($autore->id_autore); ?>&page=1"><?php echo e($autore->autore); ?></a> <span class="numFilter">(<?php echo e($autore->numero); ?>)</span></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                    <?php if(empty($_GET['genere'])): ?>
                        <div class="filter-card">
                            <p>Genere</p>
                            <ul>
                                <?php $__currentLoopData = $generi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e($url . ((!$_GET)? '?':'&')); ?>genere=<?php echo e($genere->id_genere); ?>&page=1"><?php echo e($genere->genere); ?></a> <span class="numFilter">(<?php echo e($genere->numero); ?>)</span></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php if(empty($_GET['editore'])): ?>
                        <div class="filter-card">
                            <p>Editore</p>
                            <ul>
                                <?php $__currentLoopData = $editori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $editore): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e($url . ((!$_GET)? '?':'&')); ?>editore=<?php echo e($editore->id_editore); ?>&page=1"><?php echo e($editore->editore); ?></a> <span class="numFilter">(<?php echo e($editore->numero); ?>)</span></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php if(empty($_GET['lingua'])): ?>
                        <div class="filter-card">
                            <p>Lingua</p>
                            <ul>
                                <?php $__currentLoopData = $lingue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lingua): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e($url . ((!$_GET)? '?':'&')); ?>lingua=<?php echo e($lingua->tag_lingua); ?>&page=1"><?php echo e($lingua->lingua); ?></a> <span class="numFilter">(<?php echo e($lingua->numero); ?>)</span></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if(empty($_GET['anno'])): ?>
                        <div class="filter-card">
                            <p>Anno di Stampa</p>
                            <ul>
                                <?php $__currentLoopData = $anni; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e($url . ((!$_GET)? '?':'&')); ?>anno=<?php echo e($anno->anno_stampa); ?>&page=1"><?php echo e($anno->anno_stampa); ?></a> <span class="numFilter">(<?php echo e($anno->numero); ?>)</span></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
            </div>
        </div>
        <div class="col-8">
            <?php if($author != null): ?>
                <label style="margin-bottom: 10px;"><a href="/search">< Cerca su tutti i titoli</a></label>
            <?php endif; ?>

            <?php if($schedaAutore != null): ?>
                <div class="cc-card author-card row" style="margin-bottom: 20px;">
                    <div class="d-flex">
                        <img src="<?php echo e($schedaAutore->avatar); ?>">
                        <div class="author">
                            <p><?php echo e($schedaAutore->belongsAutore->autore); ?></p>
                            <label><?php echo e($schedaAutore->location); ?>, <?php echo e($schedaAutore->anno_nascita); ?> (<?php echo e($schedaAutore->belongsNazione->nazione); ?>)</label>
                        </div>

                    </div>
                    <div class="descrizione-author">
                        <label><?php echo str_replace("\n", "<br>", $schedaAutore->descrizione); ?></label>
                    </div>
                </div>
            <?php endif; ?>

                <div class="cc-card spacer-card row search-card">
                    <h5 style="border: none;">Tutti i risultati <?php echo e((!empty($_GET['query']))? "per ".$_GET['query'] : ""); ?> (<?php echo e($libri->total()); ?>)</h5>
                    <div class="col-8">
                        <div class="search-wrapper">
                            <form method="GET" id="search" action="">
                                <input autocomplete="off" name="query" style="width: 100%" type="text" placeholder="Cerca per titolo, autore oppure ISBN" @input="update">
                                <i class="fas fa-search" @click="search"></i>
                            </form>
                        </div>
                        <ul class="search-list">
                            <li v-for="(row,rid) in libri" :key="rid">
                                <a :href="'/search/?query=' + row.query">
                                    <div class="option-search">
                                        <div class="col-lg-12">
                                            <p v-html="row.query"></p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-4">
                        <form method="GET" id="orderForm">
                            <select @change="order" name="orderby" class="form-select" style="width: 100%">
                                <option value="default">Ordina per Voti</option>
                                <option value="annoDesc">Anno: Più recente</option>
                                <option value="annoAsc">Anno: Meno recente</option>
                                <option value="titoloAsc">Titolo A-Z</option>
                                <option value="titoloDesc">Titolo Z-A</option>
                                <option value="prestati">Più prestati</option>
                                <option value="copie">Più copie</option>
                            </select>
                            <input type="hidden" name="page" value="1">
                        </form>
                    </div>
            </div>

            <div class="libri">
                <?php $__currentLoopData = $libri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $libro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="libro row cc-card spacer-card">
                    <div class="col-3">
                        <a href="/book/<?php echo e($libro->ISBN); ?>">
                            <img onerror="imgError(this)" src="https://pictures.abebooks.com/isbn/<?php echo e($libro->ISBN); ?>-us-300.jpg" alt="cover">
                        </a>
                    </div>
                    <div class="col-9 row">
                        <div class="col-8">
                            <p class="<?php echo e((strlen($libro->titolo) > 100)? 'too-long': ''); ?>"><a href="/book/<?php echo e($libro->ISBN); ?>"><?php echo e($libro->titolo); ?></a></p>
                                <p><?php if(count($libro->belongsAutori) != 0): ?>
                                    di
                                        <?php $__currentLoopData = $libro->belongsAutori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $autore): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="/search/autore/<?php echo e($autore->belongsAutore->id_autore); ?>?page=1"><?php echo e($autore->belongsAutore->autore); ?></a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </p>
                            <p><a href="/search?editore=<?php echo e($libro->belongsEditore->id_editore); ?>&page=1"><?php echo e($libro->belongsEditore->editore); ?></a>, <?php echo e($libro->anno_stampa); ?></p>

                            <?php if(round($libro->media) > 0): ?>
                            <div class="d-flex" style="margin-top: 10px">
                                <p class="media"><?php echo e(number_format((float) $libro->media, 2, '.', '')); ?></p>
                                <div class="d-block align-self-center">
                                    <?php if($libro->media > 4.5): ?>
                                    <p class="alert-book">Consigliato</p>
                                    <?php endif; ?>
                                    <div class="d-flex medie">
                                        <?php for($i = 1; $i < round($libro->media)+1; $i++): ?>
                                            <i class="fas fa-star"></i>
                                        <?php endfor; ?>
                                            <?php for($i = 0; $i < 5-round($libro->media); $i++): ?>
                                                <i class="fas fa-star removed"></i>
                                            <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(count($libro->belongsGeneri) != 0): ?>
                                <div class="genere">
                                    <p>Generi:</p>
                                    <div class="d-flex flex-column">
                                        <?php $__currentLoopData = $libro->belongsGeneri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="/search?genere=<?php echo e($genere->belongsGenere->id_genere); ?>&page=1"><?php echo e($genere->belongsGenere->genere); ?></a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-4 dettagli">
                            <label class="copie">Copie presenti: <b><?php echo e($libro->copie); ?></b></label>
                            <label class="copie">Prestati: <b><?php echo e($libro->prestiti); ?></b></label>
                            <?php if(!empty($_GET['orderby']) && $_GET['orderby'] == "prestati"): ?>
                                <label class="copie"><i class="fas fa-arrow-up"></i> Prestiti totali: <b><?php echo e($libro->prestitiTotali); ?></b></label>
                            <?php endif; ?>

                            <?php if(Auth()->user()): ?>
                                <a href="/post/preferiti/<?php echo e($libro->ISBN); ?>" style="text-decoration: none"><button class="d-block btn <?php if($libro->preferito == 0): ?> btn-primary <?php else: ?> btn-danger <?php endif; ?>" style="font-size: 12px;margin-bottom: 10px;"><?php if($libro->preferito == 0): ?>Salva sui preferiti <?php else: ?> Rimuovi dai preferiti <?php endif; ?></button></a>
                            <?php endif; ?>
                            <?php if(($libro->copie - $libro->prestiti) != 0): ?>
                                <div class="status disponibile d-flex row-direction">
                                    <i class="fas fa-check"></i><p>Disponibile</p>
                                </div>
                            <?php else: ?>
                                <div class="status d-flex row-direction" style="color: darkred">
                                    <i class="fas fa-times"></i><p style="margin-left: 5px;">Non disponibile</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php if($libri->hasPages()): ?>
            <div class="pages cc-card filter-card row" style="margin-bottom: 50px;">
                <a href="<?php echo e((isset($_GET['page']) && $libri->currentPage() != 1)?str_replace('page='.$_GET['page'], 'page='.explode('?page=', $libri->previousPageUrl())[1], $url):$libri->previousPageUrl()); ?>" class="button-clicker col-3">
                    <?php if($libri->currentPage() != 1): ?>
                        <svg fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        <span>Precedente</span>
                    <?php endif; ?>
                </a>

                <span class="col-6" style="text-align: center; letter-spacing: 3px;">Pagina: <?php echo e($libri->currentPage()); ?></span>

                <a href="<?php echo e((isset($_GET['page'])  && $libri->currentPage() != $libri->lastPage())?str_replace('page='.$_GET['page'], 'page='.explode('?page=', $libri->nextPageUrl())[1], $url):$libri->nextPageUrl()); ?>" class="button-clicker col-3 text-right">
                    <?php if($libri->currentPage() != $libri->lastPage()): ?>
                    <span>Successivo</span>
                    <svg fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <?php endif; ?>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <?php if(!empty($_GET['orderby'])): ?>
    <script>
        $(document).ready(function() {
            $('#orderForm select').val("<?php echo e($_GET['orderby']); ?>");
        });
    </script>
    <?php endif; ?>
    <script src="/js/app.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/edoardo/PhpstormProjects/bibliotecaLaravel/resources/views/book/index.blade.php ENDPATH**/ ?>