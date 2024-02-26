@extends('template.admin')
@section('title', 'Presta - Biblioteca')

@section('admin-content')
<form method="POST">
    @csrf
    <div x-data="bookLoanComponent()" class="cc-card" style="padding: 10px 20px;">
        <h5>Presta un libro</h5>

        <template x-if="prenota !== null">
            <div class="input-wrapper row">
                <div class="col-4">
                    <img :src="image" alt="cover" style="width: 100%;">
                </div>
                <div class="col-8">
                    <p style="font-size: 18px;" class="align-self-center" x-html="prenota.titolo"></p>
                    <p style="font-size: 16px;" class="align-self-center" x-html="prenota.editore"></p>
                    <p style="font-size: 14px; margin-top: 5px;" class="align-self-center" x-text="'Anno Stampa: ' + prenota.anno_stampa"></p>
                    <p style="font-size: 14px;" class="align-self-center" x-text="prenota.ISBN"></p>
                </div>
            </div>
        </template>

        <div class="input-wrapper row">
            <div class="col-12">
                <label>Scannerizza l'ISBN</label>
                <input type="text" name="ISBN" class="form-control" x-on:input="scannerISBN">
            </div>
        </div>

        <template x-if="prenota !== null && prenota.copie.length !== 0">
            <div class="input-wrapper row">
                <div class="col-12">
                    <label>Seleziona il numero della copia</label>
                    <select id="copiaselect" name="copia" class="form-select" style="width: 100%; height: min-content;" x-on:change="selectCopia($event)" required>
                        <template x-for="(copia, index) in prenota.copie" :key="index">
                            <option x-text="copia.id_copia"></option>
                        </template>
                    </select>
                </div>
            </div>
        </template>

        <template x-if="prenota !== null && prenota.copie.length !== 0">
            <div x-show="prenota.copie[num_copia].prenotato.length !== 0" class="input-wrapper row">
                <div class="col-12">
                    <label>Prenotazione trovata!</label>
                    <input required readonly type="text" class="form-control" :value="prenota.copie[num_copia].prenotato[0].name + ' ' + prenota.copie[num_copia].prenotato[0].surname">
                    <input type="hidden" name="user" :value="prenota.copie[num_copia].prenotato[0].id">
                </div>
                <input type="hidden" name="ISBN" :value="prenota.ISBN">
                <div class="input-wrapper row">
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Salva</button>
                    </div>
                </div>
            </div>
        </template>

        <template x-if="prenota !== null && prenota.copie.length === 0">
            <div class="input-wrapper row">
                <div class="col-12">
                    <label>Non ci sono copie disponibili!</label>
                </div>
            </div>
        </template>
    </div>
</form>
@endsection

@section('script')
<script>
    function bookLoanComponent() {
        return {
            prenota: null,
            image: undefined,
            num_copia: 0,
            selectCopia(event) {
                this.num_copia = parseInt(event.target.value);
            },
            scannerISBN(event) {
                const isbn = event.target.value;

                if (isbn.length === 13) {
                    fetch('/api/admin/search/' + isbn)
                        .then(response => {
                            if (response.ok) {
                                return response.json();
                            }
                            throw new Error('Network response was not ok.');
                        })
                        .then(data => {
                            if(data.copie.every(copia => copia.prenotato.length !== 0)){
                                this.prenota = data;
                                this.image = "/covers/" + data.ISBN;
                            }
                        })
                        .catch(error => {
                            console.error('There has been a problem with your fetch operation:', error);
                            this.prenota = null;
                            this.image = undefined;
                        });
                } else {
                    this.prenota = null;
                    this.image = undefined;
                }
            }
        };
    }
</script>
@endsection