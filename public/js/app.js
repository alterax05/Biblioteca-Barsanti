new Vue({
  el: "#main",
  data: {
    libri: [],
    books: [],

    page: parseInt($("#page").val()),
    lastPage: 1,
    count: 0,
    scheda_autore: null,

    autori: [],
    editori: [],
    generi: [],
    anni: [],
    lingue: [],

    //filter
    query: $("#query").val(),
    orderby: $("#orderby").val(),
    editore: $("#editore").val(),
    autore: $("#autore").val(),
    genere: $("#genere").val(),

    nazione: $("#nazione").val(),
    sezione: $("#sezione").val(),
  },
  mounted() {
    this.loadBooks();
  },

  methods: {
    update: function (event) {
      value = event.target.value;

      let uri = encodeURI("/api/search/" + value);
      if (value != "") {
        axios
          .get(uri)
          .then((response) => {
            this.libri = response.data;
          })
          .catch((error) => {
            console.error(error);
          });
      } else {
        this.libri = [];
      }
    },
    orderLoad: function () {
      this.orderby = $("#orderby").val();
      history.pushState(
        {},
        null,
        loadUrlParameters(document.location.href, "orderby", this.orderby)
      );
      this.loadBooks();
    },
    change: function (action, variable, text) {
      action();
      history.pushState(
        {},
        null,
        loadUrlParameters(document.location.href, variable, text)
      );
      this.loadBooks();
    },
    clearVariable: function (action, variable) {
      action();
      history.pushState(
        null,
        null,
        loadUrlParameters(document.location.href, variable, "").replace(
          variable + "=",
          ""
        )
      );
      this.loadBooks();
    },
    scrollToTop() {
      $(window).scrollTop(0);
    },
    loadQuery: function (value) {
      if (value === "") {
        value = $("#searchInp").val();
        if (value === "") value = "NaN";
      }
      this.query = value;

      this.clearFilters();

      this.libri = [];
      this.page = 1;
      $("#orderForm select").val(this.orderby);

      let protocol = document.location.protocol;

      history.pushState(
        {},
        null,
        loadUrlParameters(
          protocol+ "//" + document.location.host + "/search",
          "query",
          this.query
        )
      );

      this.loadBooks();

      if (this.scheda_autore != null) {
        history.pushState(
          {},
          null,
          protocol + "//" +
            document.location.host +
            "/search/autore/" +
            this.scheda_autore.id_autore
        );
      }

      this.libri = [];
    },
    loadBooks: function () {
      $("#loading").show();
      axios({
        url:
          "/api/get_books/page=" +
          this.page +
          "/query=" +
          this.query +
          "/orderby=" +
          this.orderby +
          "/genere=" +
          this.genere +
          "/autore=" +
          this.autore +
          "/editore=" +
          this.editore +
          "/nazione=" +
          this.nazione +
          "/sezione=" +
          this.sezione,
        method: "post",
        headers: {
          "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr("content"),
          "X-Requested-With": "XMLHttpRequest",
        },
      })
        .then((response) => {
          this.books = response.data.books;
          this.lastPage = response.data.pages;
          this.count = response.data.elements;
          this.scheda_autore = response.data.scheda_autore;

          this.autori = response.data.autori;
          this.editori = response.data.editori;
          this.generi = response.data.generi;
          this.anni = response.data.anni;
          this.lingue = response.data.lingue;
        })
        .then(() => {
          $("#loading").hide();
          this.scrollToTop();
        })
        .catch((error) => {
          console.error(error);
        });
    },

    clearFilters: function () {
      this.orderby = "default";
      this.editore = 0;
      this.genere = 0;
      this.autore = 0;
      history.pushState(
        {},
        null,
        document.location.protocol + "//" + document.location.host + "/search"
      );
    },
  },
});

function loadUrlParameters(urlstring, param, value) {
  var url = new URL(urlstring);
  var search_params = url.searchParams;

  search_params.set(param, value);
  url.search = search_params.toString();
  return url.toString();
}
