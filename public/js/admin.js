new Vue({
    el: '#main',
    data: {
        libri: [],
        image: "",
        prenota: null,
        copia: 0
    },
    methods: {
        update: function(event) {
            let value = event.target.value;

            if(value !== '') {
                ;(async () => {
                    const response = await axios({
                        url: '/api/autori/' + value.replace(' ', '-'),
                        method: 'get'
                    })
                    this.libri = response.data;
                })()
            }else{
                this.libri = [];
            }
        },
        changeValue: function(value) {
            $('#autore').val(value);
            this.libri = [];
        },
	rest: function(event) {
            let value = event.target.value;

            if(value.length === 13) {
                ;(async () => {
                    const response = await axios({
                        url: '/api/admin/restituisci/' + value,
                        method: 'get'
                    })
                    if(response.data !== undefined) {
                        this.restituisci = response.data
                    }else{
                        this.restituisci = null
                    }
                })()

            }else{
                this.restituisci = null
            }
        },
        scannerISBN: function(event) {
            let value = event.target.value;

            if(value.length === 13) {
                this.image = "https://pictures.abebooks.com/isbn/" + value + "-us-300.jpg"

                ;(async () => {
                    const response = await axios({
                        url: '/api/admin/search/' + value,
                        method: 'get'
                    })

                    if(response.data !== undefined) {
                        this.prenota = response.data
                    }else{
                        this.prenota = null
                    }
                })()

            }else{
                this.image = ""
                this.prenota = null
            }
        },
        selectCopia(event) {
            this.copia = $("#copiaselect option:selected").index()
        }
    },
})

function imgError(image) {
    image.onerror = "";
    image.src = "/imgs/notcover-min.png";
    return true;
}

