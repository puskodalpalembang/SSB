<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <style>
    /* CSS untuk perangkat seluler dengan lebar layar kurang dari atau sama dengan 768px */
    @media (max-width: 768px) {
      body {
        font-size: 14px; /* Ukuran teks lebih kecil */
      }
      .container {
        padding: 20px; /* Ruang padding yang lebih kecil di dalam kontainer */
      }
      /* Atur lebar elemen input agar sesuai dengan layar seluler */
      input[type="text"], select[class="form-control"], textarea[class="form-control"] {
        width: 225%;
      }
    }

    /* CSS untuk mengatur konten ke tengah halaman */
    body {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .container {
      text-align: center;
    }

    form {
      text-align: left;
    }
  </style>
  <title>Form Support Smart Patrol-SSB</title>
</head>
<body>
<section>
  <div class="container">
    <h5 style="color: blue;">Form Support Smart Patrol-SSB</h5>
    <br>
    <form>
      <div class="row">
        <div class="col-6">
          <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="text" class="form-control" name="tanggal" id="exampleFormControlInput2" readonly>
          </div>
          <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="">
          </div>
          <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <input type="text" class="form-control" name="jabatan" id="exampleFormControlInput1" placeholder="">
          </div>
          <div class="form-group">
            <label for="lokasi">Lokasi</label>
            <input type="text" class="form-control" name="lokasi" id="exampleFormControlInput1" placeholder="">
          </div>
          <div class="form-group">
            <label for="pos">Pos</label>
            <input type="text" class="form-control" name="pos" id="exampleFormControlInput1" placeholder="">
          </div>
          <div class="form-group">
            <label for="shift">Shift</label>
            <select class="form-control" name="shift" id="shift">
              <option value="" disabled selected hidden>Select Shift</option>
              <option value="Pagi">P</option>
              <option value="Malam">M</option>
              <option value="C">C</option>
              <option value="B">B</option>
              <option value="A">A</option>
              <option value="BC">BC</option>
              <option value="AC">AC</option>
              <option value="R">R</option>
              <option value="Admin">Admin</option>
            </select>
          </div>
          <div class="form-group">
            <label for="problem">Problem</label>
            <select class="form-control" name="problem" id="problem">
              <option value="" disabled selected hidden>Select a problem</option>
              <option value="PIN Telat Masuk">PIN Telat Masuk</option>
              <option value="PIN Geofence">PIN Geofence</option>
              <option value="PIN Pulang Awal">PIN Pulang Awal</option>
              <option value="Aplikasi Error">Aplikasi Error</option>
              <option value="Perubahan Schedule">Perubahan Schedule</option>
              <option value="Lain-Lain">Lain-Lain</option>
            </select>
          </div>
          <div class="form-group">
            <label for="message">Keterangan</label>
            <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3"></textarea>
          </div>
          <input type="hidden" name="noWA" value="6281286011684">
          <button type="button" name="submit" class="btn btn-primary" onclick="submitForm()">Send</button>
        </div>
      </div>
    </form>
  </div>
</section>

<script>
  // Mendapatkan elemen input tanggal
  var tanggalInput = document.querySelector('input[name="tanggal"]');

  // Membuat fungsi untuk mengisi tanggal dan waktu saat ini
  function setDateTime() {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    var hh = String(today.getHours()).padStart(2, '0');
    var min = String(today.getMinutes()).padStart(2, '0');
    var ss = String(today.getSeconds()).padStart(2, '0');
    var formattedDateTime = dd + '-' + mm + '-' + yyyy + ' | ' + hh + ':' + min + ':' + ss;
    tanggalInput.value = formattedDateTime;
  }

  // Panggil fungsi setDateTime saat halaman dimuat
  setDateTime();

  // Atur interval untuk memperbarui waktu setiap detik
  setInterval(setDateTime, 1000);
</script>

<script>
  // Fungsi untuk mengirim data ke WhatsApp
  function sendToWhatsApp(tanggal, name, jabatan, lokasi, pos, shift, problem, message) {
    var messageText = "Tanggal: " + tanggal + "%0A" +
                     "Nama: " + name + "%0A" +
                     "Jabatan: " + jabatan + "%0A" +
                     "Lokasi: " + lokasi + "%0A" +
                     "Pos: " + pos + "%0A" +
                     "Shift: " + shift + "%0A" +
                     "Problem: " + problem + "%0A" +
                     "Keterangan: " + message;

    var whatsappLink = "https://api.whatsapp.com/send?phone=&text=" + messageText;
    window.open(whatsappLink, "_blank");
  }

  // Fungsi untuk mengirim data ke Google Spreadsheet
  function sendToGoogleSpreadsheet(formData) {
    fetch("https://script.google.com/macros/s/AKfycbyP62KRPqTohsPf0SMqDhtmEGeHfyoxpazruLJGwpWDVIWZ_qTdCC9D_k2pJrbBWhvxOg/exec", {
      method: "POST",
      body: formData,
    })
      .then(function (response) {
        // Handle the response here (e.g., show a success message)
      })
      .catch(function (error) {
        // Handle errors (e.g., show an error message)
      });
  }

  // Fungsi untuk menangani pengiriman data
  function submitForm() {
    // Mendapatkan tanggal saat ini
    var tanggal = document.querySelector('input[name="tanggal"]').value;
    var name = document.querySelector('input[name="name"]').value;
    var jabatan = document.querySelector('input[name="jabatan"]').value;
    var lokasi = document.querySelector('input[name="lokasi"]').value;
    var pos = document.querySelector('input[name="pos"]').value;
    var shift = document.querySelector('select[name="shift"]').value;
    var problem = document.querySelector('select[name="problem"]').value;
    var message = document.querySelector('textarea[name="message"]').value;

    sendToWhatsApp(tanggal, name, jabatan, lokasi, pos, shift, problem, message);

    var formData = new FormData();
    formData.append('tanggal', tanggal);
    formData.append('name', name);
    formData.append('jabatan', jabatan);
    formData.append('lokasi', lokasi);
    formData.append('pos', pos);
    formData.append('shift', shift);
    formData.append('problem', problem);
    formData.append('message', message);

    sendToGoogleSpreadsheet(formData);
    // Tambahkan kode lain yang perlu dijalankan setelah mengirim data.
  }
</script>

</body>
</html>
