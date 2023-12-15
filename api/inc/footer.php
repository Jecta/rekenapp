<br>
<footer class="py-3 my-4">
  <ul class="nav justify-content-left pb-3 mb-3">
    <p class="text-center text-muted">Gemaakt door <a href="https://jeremybosma.nl" target="_blank">Jeremy Bosma</a></p>
</footer>

<!-- bootstrap theme switcher van google ergens -->
<script>
  const btnSwitch = document.getElementById('btnSwitch');
  const currentTheme = localStorage.getItem('theme');

  if (currentTheme) {
    document.documentElement.setAttribute('data-bs-theme', currentTheme);
  }

  btnSwitch.addEventListener('click', () => {
    if (document.documentElement.getAttribute('data-bs-theme') == 'dark') {
      document.documentElement.setAttribute('data-bs-theme', 'light');
      localStorage.setItem('theme', 'light');
    } else {
      document.documentElement.setAttribute('data-bs-theme', 'dark');
      localStorage.setItem('theme', 'dark');
    }
  });
</script>

<!-- sommen berekenen (plus, min, keer, delen) -->
<script>
  let errorTekst =
    "Er is iets misgegaan bij het genereren van je antwoord, heb je wel een cijfer ingevuld?";

  function copyAntwoord() {
    var copyText = document.getElementById("antwoord");

    if (copyText.innerText == "") {
      alert("Er is geen antwoord om te kopieren.");
      return;
    }

    if (copyText.innerText == errorTekst) {
      alert("Je kan geen error kopieren.");
      return;
    }

    var range = document.createRange();
    range.selectNode(copyText);
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(range);

    try {
      document.execCommand("copy");
      alert("Text gekopieerd: " + copyText.innerText);
    } catch (err) {
      console.error("Kon de text niet kopieren: ", err);
    }

    window.getSelection().removeAllRanges();
  }

  function berekenPlus() {
    let eersteInput = parseFloat(document.getElementById("plus1").value);
    let TweedeInput = parseFloat(document.getElementById("plus2").value);

    if (isNaN(eersteInput + TweedeInput)) {
      document.getElementById("antwoord").innerHTML = errorTekst;
    } else {
      document.getElementById("antwoord").innerHTML =
        eersteInput + "+" + TweedeInput + "=" + (eersteInput + TweedeInput);
    }
  }

  function berekenMin() {
    let eersteInput = parseFloat(document.getElementById("-1").value);
    let TweedeInput = parseFloat(document.getElementById("-2").value);

    if (isNaN(eersteInput - TweedeInput)) {
      document.getElementById("antwoord").innerHTML = errorTekst;
    } else {
      document.getElementById("antwoord").innerHTML =
        eersteInput + "-" + TweedeInput + "=" + (eersteInput - TweedeInput);
    }
  }

  function berekenX() {
    let eersteInput = parseFloat(document.getElementById("x1").value);
    let TweedeInput = parseFloat(document.getElementById("x2").value);

    if (isNaN(eersteInput * TweedeInput)) {
      document.getElementById("antwoord").innerHTML = errorTekst;
    } else {
      document.getElementById("antwoord").innerHTML =
        eersteInput + "x" + TweedeInput + "=" + eersteInput * TweedeInput;
    }
  }

  function berekenDelen() {
    let eersteInput = parseFloat(document.getElementById("deel1").value);
    let TweedeInput = parseFloat(document.getElementById("deel2").value);

    if (isNaN(eersteInput / TweedeInput)) {
      document.getElementById("antwoord").innerHTML = errorTekst;
    } else {
      document.getElementById("antwoord").innerHTML =
        eersteInput + "÷" + TweedeInput + "=" + eersteInput / TweedeInput;
    }
  }
</script>

<!-- genereer tafel -->
<script>
  function genereerTafel() {
    let tafelVan = parseFloat(document.getElementById("tafelInput").value);

    if (isNaN(tafelVan)) {
      document.getElementById("tafel").innerHTML = errorTekst;
    } else {
      let teller = 1;
      let uitkomst = 0;
      let tekst = "";

      while (teller < 11) {
        uitkomst = teller * tafelVan;
        tekst += teller + "x" + tafelVan + "=" + uitkomst + "<br>";
        teller++;
      }
      document.getElementById("tafel").innerHTML = tekst;
    }
  }
</script>

<!-- tafels oefenen, modified code van Ids -->
<script>
  let berekendeoplossing;

  function showOpdracht() {
    let tafelvan = document.getElementById("inputTafelvan").value;
    let tafeltot = document.getElementById("inputTafeltot").value;

    if (tafelvan == 0 || tafeltot == 0) {
      alert(errorTekst);
      return;
    } else if (tafelvan < 0 || tafeltot < 0) {
      alert("Je hebt een negatief getal gebruikt, probeer het opnieuw.");
      return;
    }

    let randomnmbr = Math.floor(Math.random() * tafeltot) + 1;
    let opgave = randomnmbr + " x " + tafelvan;
    document.getElementById("inputOpdracht").value = opgave;
    document.getElementById("inputOplossing").focus();

    berekendeoplossing = randomnmbr * tafelvan;

    setTimeout((document.getElementById("inputOplossing").value = ""), 5000);

    document
      .getElementById("inputOplossing")
      .classList.remove("is-valid", "is-invalid");
  }

  function checkOplossing() {
    let ingevoerdeoplossing = document.getElementById("inputOplossing").value;
    if (berekendeoplossing == ingevoerdeoplossing) {
      document.getElementById("inputOplossing").classList.remove("is-invalid");
      document.getElementById("inputOplossing").classList.add("is-valid");
      document.getElementById("alert-banner").classList.add("alert", "alert-success");
      document.getElementById("alert-banner").innerHTML =
        "Goed gedaan, je krijgt een nieuwe som over 5 seconden.";

      setTimeout(function () {
        document.getElementById("alert-banner").innerHTML = "";
        document.getElementById("alert-banner").classList.remove("alert", "alert-success", "alert-danger");
      }, 5000);

      setTimeout(showOpdracht, 5000);
    } else {
      document.getElementById("inputOplossing").classList.add("is-invalid");
    }
  }
</script>

<!-- eenheden berekenen, modified code van Ids -->
<script>
  const eenheden = ["mm", "cm", "dm", "m", "dam", "hm", "km"];

  let index_left = 0;
  let index_right = 0;

  let dim_select = document.getElementById("dim_select");

  let inp_left = document.getElementById("inp_left");
  let eenh_left = document.getElementById("eenh_left");

  let inp_right = document.getElementById("inp_right");
  let eenh_right = document.getElementById("eenh_right");

  let opgave_float = 3.14;
  let right_answer = undefined;

  let factor = 10;
  let aantal_stappen = 0;


  function makeProblem() {
    index_left = Math.floor(Math.random() * 7);
    index_right = Math.floor(Math.random() * 7);

    if (index_left == index_right) {
      // alert("test dezelfde eenheden gegenereerd er wordt een nieuwe som gemaakt.");
      return makeProblem();
    }

    eenh_left.innerHTML = eenheden[index_left] + "<sup>" + dim_select.value + "</sup>";
    eenh_right.innerHTML = eenheden[index_right] + "<sup>" + dim_select.value + "</sup>";

    opgave_float = (Math.random() * 1000).toFixed(3);
    inp_left.value = opgave_float;

    inp_right.value = "";
    inp_right.focus();

    document.getElementById("alert-banner").classList.remove("alert", "alert-success", "alert-danger");
    document.getElementById("alert-banner").innerHTML = "";
    document.getElementById("inp_right").classList.remove("is-valid", "is-invalid");
  }

  function checkSolution() {
    if (dim_select.value > 1) {

      factor = Math.pow(10, dim_select.value);
    }

    if (index_left < index_right) {
      aantal_stappen = index_right - index_left;
      right_answer = opgave_float / Math.pow(factor, aantal_stappen);
    } else {
      aantal_stappen = index_left - index_right;
      right_answer = opgave_float * Math.pow(factor, aantal_stappen);
    }

    if (inp_right.value == right_answer) {
      document.getElementById("inp_right").classList.remove("is-invalid");
      document.getElementById("inp_right").classList.add("is-valid");
      document.getElementById("alert-banner").classList.add("alert", "alert-info");
      document.getElementById("alert-banner").innerHTML =
        "Goed gedaan, je krijgt een nieuwe som over 5 seconden.";

      setTimeout(function () {
        document.getElementById("alert-banner").innerHTML = "";
      }, 5000);

      setTimeout(makeProblem, 5000);
    } else {
      document.getElementById("inp_right").classList.add("is-invalid");
      if (inp_right.value == !right_answer) {
        document.getElementById("alert-banner").classList.add("alert", "alert-info");
        document.getElementById("alert-banner").innerHTML = "Hint: factor = " + factor;
      }
    }
  }
</script>

<!-- SomSomMagie deel 1 -->
<script>
  let inp_A1 = document.getElementById("inp_A1");
  let inp_D1 = document.getElementById("inp_D1");
  let inp_D2 = document.getElementById("inp_D2");
  let inp_D3 = document.getElementById("inp_D3");
  let inp_C4 = document.getElementById("inp_C4");
  let inp_B4 = document.getElementById("inp_B4");

  let opl_B2 = document.getElementById("opl_B2");
  let opl_C2 = document.getElementById("opl_C2");
  let opl_B3 = document.getElementById("opl_B3");
  let opl_C3 = document.getElementById("opl_C3");

  function LosSomSomOp() {
    document.getElementById("alert-banner").classList.remove("alert", "alert-success", "alert-danger");
    document.getElementById("alert-banner").innerHTML = "";

    let gok = 1;
    let decision = true;

    while (decision = true) {

      opl_B2.value = gok;
      opl_C2.value = parseInt(inp_D2.value) - parseInt(opl_B2.value);
      opl_B3.value = parseInt(inp_B4.value) - parseInt(opl_B2.value);
      opl_C3.value = parseInt(inp_C4.value) - parseInt(opl_C2.value);

      if (parseInt(opl_B2.value) + parseInt(opl_C3.value) == parseInt(inp_A1.value)
        && parseInt(opl_B3.value) + parseInt(opl_C2.value) == parseInt(inp_D1.value)
        && parseInt(opl_B3.value) + parseInt(opl_C3.value) == parseInt(inp_D3.value)) {
        document.getElementById("alert-banner").classList.add("alert", "alert-success");
        document.getElementById("alert-banner").innerHTML = "Bingo!";
        decision = false;
      } else {
        document.getElementById("alert-banner").classList.add("alert", "alert-danger");
        document.getElementById("alert-banner").innerHTML = "Niet bingo!";
        gok++;
      }

    }
  }
</script>

<!-- SomSomMagie deel 2 -->
<script>
  function generateProblem() {
    document.getElementById("alert-banner").classList.remove("alert", "alert-success", "alert-danger");
    document.getElementById("alert-banner").innerHTML = "";

    let opl_B2 = Math.floor(Math.random() * 21);
    let opl_C2 = Math.floor(Math.random() * 21);
    let opl_B3 = Math.floor(Math.random() * 21);
    let opl_C3 = Math.floor(Math.random() * 21);

    let inp_A1 = opl_B2 + opl_C3;
    let inp_D1 = opl_B3 + opl_C2;
    let inp_D2 = opl_B2 + opl_C2;
    let inp_D3 = opl_B3 + opl_C3;
    let inp_C4 = opl_C2 + opl_C3;
    let inp_B4 = opl_B2 + opl_B3;

    document.getElementById("inp_A1").value = inp_A1;
    document.getElementById("inp_D1").value = inp_D1;
    document.getElementById("inp_D2").value = inp_D2;
    document.getElementById("inp_D3").value = inp_D3;
    document.getElementById("inp_C4").value = inp_C4;
    document.getElementById("inp_B4").value = inp_B4;

    console.log(opl_B2, opl_B3);
    console.log(opl_C2, opl_C3);
  }

  function checkSomSom() {
    let inv_B2 = parseInt(document.getElementById("opl_B2").value);
    let inv_C2 = parseInt(document.getElementById("opl_C2").value);
    let inv_B3 = parseInt(document.getElementById("opl_B3").value);
    let inv_C3 = parseInt(document.getElementById("opl_C3").value);
    if (inv_B2 == opl_B2 && inv_C2 == opl_C2 && inv_B3 == opl_B3 && inv_C3 == opl_C3) {
      document.getElementById("alert-banner").classList.add("alert", "alert-success");
      document.getElementById("alert-banner").innerHTML = "Bingo!";
    } else {
      document.getElementById("alert-banner").classList.add("alert", "alert-danger");
      document.getElementById("alert-banner").innerHTML = "Niet bingo!";
    }
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>