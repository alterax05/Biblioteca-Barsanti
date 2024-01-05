new Vue({
  el: "#main",
  data: {},
  methods: {
    recensioni: function (recensione) {
      axios({
          url: "/api/recensioni/",
          method: 'post',
          headers: {
            "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr("content"),
            "X-Requested-With": "XMLHttpRequest",
          },
          data: {
            ISBN: $('input[name="ISBN"]').val(),
            punteggio: recensione,
          },
        })
        .then((response) => {
          if (response.status === 200) {
            $(".toast").toast("show");
            $(".toast .toast-body").html("Recensione salvata con successo!");
            var i = 1;
            $(".rec").each(function () {
              if (i > recensione) $(this).addClass("removed");

              if (i <= recensione) $(this).removeClass("removed");

              i++;
            });
          }
        });
    },
    prenotazione: function () {
      axios({
          url: "/api/prenotazione",
          method: 'post',
          headers: {
            "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr("content"),
            "X-Requested-With": "XMLHttpRequest",
          },
          data: {
            id_copia: $('select[name="id_copia"]').val(),
          },
        })
        .then((response) => {
          if (response.status === 200) {
            if (response.data === "Prenotazione salvata!") {
              $("#prenota").modal("hide");
              $(".toast").toast({ delay: 5000 });
              $(".toast").toast("show");
              $(".toast .toast-body").html(
                "Prenotazione salvata con successo!"
              );
            } else {
              $("#prenota .error").html(response.data);
            }
          }
        });
    },
  },
});

function imgError(image) {
  image.onerror = "";
  image.src = "/imgs/notcover.png";
  return true;
}
