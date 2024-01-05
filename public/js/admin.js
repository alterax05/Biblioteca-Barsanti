new Vue({
  el: "#main",
  data: {
    libri: [],
    image: "",
    prenota: null,
    copia: 0,
    restituisci: null,
  },
  methods: {
    update: function (event) {
      let value = event.target.value;
      if (value !== "") {
        axios.get("/api/autori/" + value.replace(" ", "-")).then((response) => {
          this.libri = response.data;
        });
      } else {
        this.libri = [];
      }
    },
    changeValue: function (value) {
      $("#autore").val(value);
      this.libri = [];
    },
    rest: function (event) {
      let value = event.target.value;

      if (value.length === 13) {
        axios
          .get("/api/admin/restituisci/" + value)
          .then((response) => {
            if (response.data !== undefined) {
              this.restituisci = response.data;
            } else {
              this.restituisci = null;
            }
          })
          .catch((error) => {
            console.error(error);
            this.restituisci = null;
          });
      } else {
        this.restituisci = null;
      }
    },
    scannerISBN: function (event) {
      let value = event.target.value;

      if (value.length === 13) {
        this.image =
          "https://pictures.abebooks.com/isbn/" + value + "-us-300.jpg";
        axios
          .get("/api/admin/search/" + value)
          .then((response) => {
            response.data !== undefined
              ? (this.prenota = response.data)
              : (this.prenota = null);
          })
          .catch((error) => {
            console.error(error);
            this.prenota = null;
          });
      } else {
        this.image = "";
        this.prenota = null;
      }
    },
    selectCopia(event) {
      this.copia = $("#copiaselect option:selected").index();
    },
  },
});

function imgError(image) {
  image.onerror = "";
  image.src = "/imgs/notcover-min.png";
  return true;
}
