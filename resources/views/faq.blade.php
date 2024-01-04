@extends('template.layout')
@section('title', 'FAQ - Biblioteca')

@section('content')
    <div class="container col-6">
        <div id="accordion">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0"><i class="fa-solid fa-calendar-week"></i>
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Come prendere in prestito un libro
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body faq-x">
                        <p style="color:darkred">Prima di seguire la guida, nota bene che devi prima entrare nel tuo account personale!</p>
                        <p>Innanzitutto scegli un libro che ti interessa e premi sul suo nome.</p>
                        <img src="/imgs/faq/img.png">
                        <p>Ogni libro può avere diverse copie poste in diversi scaffali, puoi
                        trovare la copia che più ti aggrada in fondo alla pagina:</p>
                        <img src="/imgs/faq/img_1.png">
                        <p>A questo punto puoi prenotare la copia e tenerla da parte oppure andare
                        direttamente nella biblioteca e prendere il libro.<br>
                        Nota bene che in ogni caso il prestito deve essere registrato dal bibliotecario!</p>
                        <img src="/imgs/faq/img_2.png">
                        <p>Se sei uno studente, porta con te il Badge!</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-star"></i>
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Come recensire un libro
                        </button>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body faq-x">
                        <p style="color:darkred">Prima di seguire la guida, nota bene che devi prima entrare nel tuo account personale!</p>
                        <p>Per recensire un libro ti basterà andare sulla pagina di un libro</p>
                        <img src="/imgs/faq/img.png">
                        <p>A questo punto ti basterà premere sulle stelle e votare premendo le stelle del voto:</p>
                        <img src="/imgs/faq/img_3.png">
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-door-open"></i>
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Come registrarsi nel sito
                        </button>
                    </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body faq-x">
                        <p>
                        Gli account utente della scuola sono già registrati nel sistema (Utenti e Professori);
                            per accedere al proprio account ti basterà usare il tuo account scolastico:</p>
                        <img src="/imgs/faq/img_4.png">
                        <p>Stai attento che l'account che stai usando sia effettivamente dell'organizzazione
                        Barsanti (@barsanti.edu.it)</p>
                        <img src="/imgs/faq/img_5.png">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
