<?php
date_default_timezone_set('Asia/Jakarta');

// Ambil bulan & tahun dari URL
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

// Nama bulan dalam Bahasa Indonesia
$monthsIndo = [
  1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
  7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
];

// Hitung tanggal
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$firstDay = date('N', strtotime("$year-$month-01"));

// Dummy data kegiatan
$events = [
  "$year-$month-05" => [["judul"=>"Webinar UI/UX","waktu"=>"10.00 WIB","mentor"=>"Mentor: Sarah Amelia"]],
  "$year-$month-09" => [["judul"=>"Pelatihan Cloud Computing","waktu"=>"13.00 WIB","mentor"=>"Mentor: Budi Santoso"]],
  "$year-$month-15" => [["judul"=>"Diskusi Data Science","waktu"=>"09.00 WIB","mentor"=>"Mentor: Dinda Putri"]],
  "$year-$month-22" => [["judul"=>"Mentoring Karir IT","waktu"=>"15.00 WIB","mentor"=>"Mentor: Raka Wijaya"]],
];

// Navigasi bulan
$prevMonth = $month - 1; $prevYear = $year;
$nextMonth = $month + 1; $nextYear = $year;
if ($prevMonth < 1) { $prevMonth = 12; $prevYear--; }
if ($nextMonth > 12) { $nextMonth = 1; $nextYear++; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kalender Kegiatan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6fa;
      font-family: 'Poppins', sans-serif;
      padding-bottom: 50px;
    }
    .btn-back {
      margin: 25px 0 10px 25px;
      border-radius: 10px;
      font-weight: 500;
      color: #007bff;
      border-color: #007bff;
      transition: 0.2s;
    }
    .btn-back:hover {
      background-color: #007bff;
      color: #fff;
    }
    .page-header {
      text-align: center;
      font-weight: 600;
      color: #2b2b2b;
      margin-top: 10px;
      margin-bottom: 30px;
    }
    .main-container {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      gap: 30px;
      flex-wrap: wrap;
      max-width: 1200px;
      margin: 0 auto;
    }
    .calendar-card, .events-card {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 4px 25px rgba(0,0,0,0.08);
      padding: 30px;
    }
    .calendar-card {
      flex: 1 1 60%;
      min-width: 400px;
    }
    .events-card {
      flex: 1 1 35%;
      min-width: 300px;
      height: fit-content;
    }
    .calendar-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
    }
    .calendar-header h2 {
      font-size: 22px;
      font-weight: 600;
      color: #007bff;
    }
    .calendar-grid {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      text-align: center;
    }
    .day {
      font-weight: 600;
      color: #999;
      padding-bottom: 8px;
    }
    .date {
      padding: 12px;
      border-radius: 10px;
      margin: 2px;
      transition: 0.2s;
      cursor: pointer;
      position: relative;
    }
    .date:hover { background: #e9f4ff; }
    .has-event::after {
      content: "•";
      color: #007bff;
      font-size: 22px;
      position: absolute;
      bottom: 5px;
      left: 50%;
      transform: translateX(-50%);
    }
    .active-date {
      background: #007bff;
      color: #fff;
    }
    .event-card {
      background: #f1f8ff;
      border-radius: 15px;
      padding: 15px;
      margin-bottom: 15px;
      border-left: 5px solid #007bff;
    }
    .event-card h5 {
      font-weight: 600;
      margin-bottom: 5px;
    }
  </style>
</head>
<body>

<a href="dashboard_utama.php" class="btn btn-outline-primary btn-back">← Kembali ke Dashboard</a>

<h2 class="page-header">Kalender Kegiatan</h2>

<div class="main-container">
  <!-- Kalender -->
  <div class="calendar-card">
    <div class="calendar-header">
      <a href="?month=<?= $prevMonth ?>&year=<?= $prevYear ?>" class="btn btn-outline-primary btn-sm">‹</a>
      <h2><?= $monthsIndo[$month] . " " . $year ?></h2>
      <a href="?month=<?= $nextMonth ?>&year=<?= $nextYear ?>" class="btn btn-outline-primary btn-sm">›</a>
    </div>

    <div class="calendar-grid fw-semibold">
      <div class="day">Sen</div><div class="day">Sel</div><div class="day">Rab</div>
      <div class="day">Kam</div><div class="day">Jum</div><div class="day">Sab</div><div class="day">Min</div>

      <?php
      for ($i = 1; $i < $firstDay; $i++) echo "<div></div>";
      for ($d = 1; $d <= $daysInMonth; $d++) {
        $dateStr = "$year-$month-" . str_pad($d, 2, "0", STR_PAD_LEFT);
        $class = isset($events[$dateStr]) ? "has-event" : "";
        echo "<div class='date $class' onclick=\"showEvents('$dateStr')\">$d</div>";
      }
      ?>
    </div>
  </div>

  <!-- Daftar Kegiatan -->
  <div class="events-card">
    <h5 class="text-primary fw-semibold mb-3">Detail Kegiatan</h5>
    <div id="eventList" class="text-secondary">Pilih tanggal untuk melihat kegiatan.</div>
  </div>
</div>

<script>
const events = <?php echo json_encode($events); ?>;

function showEvents(date) {
  const eventList = document.getElementById('eventList');
  if (events[date]) {
    let html = "";
    events[date].forEach(e => {
      html += `
        <div class="event-card">
          <h5>${e.judul}</h5>
          <p class="mb-1">${e.waktu}</p>
          <p>${e.mentor}</p>
          <button class="btn btn-sm btn-primary">Gabung Sesi</button>
        </div>
      `;
    });
    eventList.innerHTML = html;
  } else {
    eventList.innerHTML = "<p>Tidak ada kegiatan pada tanggal ini.</p>";
  }

  document.querySelectorAll('.date').forEach(d => d.classList.remove('active-date'));
  document.querySelector(`.date[onclick="showEvents('${date}')"]`).classList.add('active-date');
}
</script>

</body>
</html>
