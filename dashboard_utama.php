<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include 'config.php';
$namaPengguna = htmlspecialchars($_SESSION['nama_pengguna'] ?? "Ahmad");

$userId = $_SESSION['user_id'] ?? null; // Asumsi ada user_id
$points = 0;
if ($userId) {
    $result = $conn->query("SELECT points FROM users WHERE id = $userId");
    $row = $result->fetch_assoc();
    $points = $row['points'] ?? 0;
} else {
    // Jika belum ada user_id, query berdasarkan nama (tidak ideal, ganti ke user_id)
    $namaPengguna = htmlspecialchars($_SESSION['nama_pengguna'] ?? "Ahmad");
    $stmt = $conn->prepare("SELECT points FROM users WHERE name = ?");
    $stmt->bind_param("s", $namaPengguna);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $points = $row['points'] ?? 0;
}


include 'header.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EduConnect - Dashboard</title>
  <link rel="stylesheet" href="profil_style.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <style>

    main { background:linear-gradient(180deg,#1e5ef3 0%,#5fa8ff 100%); padding:40px; min-height:100vh; }

    .welcome-box { background:#fff; border-radius:12px; padding:20px 25px; margin-bottom:25px; font-weight:500; }
    .stats { display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:30px; }
    .stat-card { background:#fff; border-radius:14px; padding:25px; text-align:center; box-shadow:0 4px 10px rgba(0,0,0,.05); }
    .stat-card h3 { font-size:14px; color:#666; margin-bottom:10px; }
    .stat-card p { font-size:22px; font-weight:700; color:#333; }

    .menu-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:30px; }
    .menu-item { border-radius:16px; padding:25px; color:#fff; box-shadow:0 5px 12px rgba(0,0,0,.08); transition:.2s; }
    .menu-item:hover { transform:translateY(-5px); }
    .menu-item h3 { font-size:18px; margin-bottom:10px; }
    .menu-item p { font-size:14px; margin-bottom:20px; }
    .menu-item button { border:none; background:#fff; color:#333; font-weight:600; padding:8px 16px; border-radius:8px; cursor:pointer; }
    .menu-item.blue { background:linear-gradient(135deg,#1e5ef3,#4d8dfc); }
    .menu-item.green { background:linear-gradient(135deg,#10b981,#34d399); }
    .menu-item.yellow { background:linear-gradient(135deg,#fbbf24,#fcd34d); color:#333; }
    .menu-item.blue,.menu-item.green,.menu-item.yellow { min-height:260px; display:flex; flex-direction:column; justify-content:space-between; }

    /* Kalender */
    .calendar-container { display:flex; gap:25px; margin-top:30px; }
    .calendar { background:#fff; border-radius:14px; padding:20px; width:65%; box-shadow:0 4px 10px rgba(0,0,0,.08); text-align:center; }
    .calendar-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; }
    .calendar-header button { background:none; border:none; font-size:18px; cursor:pointer; color:#1e5ef3; font-weight:700; }
    .calendar table { width:100%; border-collapse:collapse; }
    .calendar th, .calendar td { width:14%; padding:8px; text-align:center; font-size:13px; border-radius:6px; }
    .calendar td.today { background:#1e5ef3; color:#fff; font-weight:600; }
    .calendar th { color:#666; font-weight:600; }

    .activity-list { background:#fff; border-radius:14px; padding:20px; width:35%; box-shadow:0 4px 10px rgba(0,0,0,.08); }
    .activity-list h3 { color:#1e5ef3; font-size:16px; margin-bottom:10px; }
    .activity-item { padding:10px 0; border-bottom:1px solid #eee; }
    .activity-item:last-child { border-bottom:none; }
    .activity-item h4 { font-size:14px; margin-bottom:4px; }
    .activity-item p { font-size:12px; color:#555; }

    .report-box { background:#fff; border-radius:12px; padding:20px 25px; margin-top:25px; display:flex; align-items:center; justify-content:space-between; box-shadow:0 3px 8px rgba(0,0,0,.05); }
    .report-box button { border:1.5px solid #ef4444; background:#fff; color:#ef4444; font-weight:600; border-radius:8px; padding:8px 16px; cursor:pointer; transition:.3s; }
    .report-box button:hover { background:#ef4444; color:#fff; }

    .btn {
      display: inline-block;
      background: white;
      color: #2563eb;
      font-weight: 600;
      padding: 10px 18px;
      border-radius: 8px;
      text-decoration: none;
      transition: 0.3s;
    }

    .btn:hover {
      background: #2563eb;
      color: white;
    }

    .menu-btn {
      display: inline-block;
      background: #fff;
      color: #333;
      font-weight: 600;
      padding: 8px 16px;
      border-radius: 8px;
      text-decoration: none;
      transition: 0.3s;
    }
    
    .menu-btn:hover {
      background: #1e5ef3;
      color: #fff;
    }

  </style>
</head>
<body>

  <main>
    <div class="welcome-box">
      <span>Selamat Datang, <?= $namaPengguna; ?>! 👋</span><br>
      <small>Lanjutkan perjalanan belajarmu hari ini dan raih pencapaian baru</small>
    </div>

    <div class="stats">
      <div class="stat-card"><h3>Materi Dipelajari</h3><p>24</p></div>
      <div class="stat-card"><h3>Jam Belajar</h3><p>48</p></div>
      <div class="stat-card"><h3>Poin Belajar</h3><p><?= $points ?></p></div>
      <div class="stat-card"><h3>Sertifikat</h3><p>3</p></div>
    </div>

    <div class="menu-grid">
      <div class="menu-item blue">
        <h3>Bank Materi Ajar</h3>
        <p>Akses ribuan materi pembelajaran dari mentor terbaik</p>
        <a href="jelajah_materi.php" class="btn">Jelajahi Materi</a>
      </div>
      <div class="menu-item green">
        <h3>Video Pembelajaran</h3>
        <p>Tonton video pembelajaran interaktif dan menarik</p>
        <a href="#" class="btn">Tonton Sekarang</a>
      </div>
      <div class="menu-item yellow">
        <h3>Kelas Mentor</h3>
        <p>Bergabung dengan kelas mentor dan diskusi interaktif</p>
        <a href="#" class="btn">Lihat Kelas</a>
      </div>
    </div>

    <div class="calendar-container">
      <div class="calendar">
        <div class="calendar-header">
          <button id="prevMonth">←</button>
          <h3 id="monthYear"></h3>
          <button id="nextMonth">→</button>
        </div>
        <div id="calendarBody"></div>
      </div>

      <div class="activity-list">
        <h3>Kegiatan Bulan Ini</h3>
        <div class="activity-item">
          <h4>Workshop Desain UI/UX</h4>
          <p>10 Oktober 2025</p>
        </div>
        <div class="activity-item">
          <h4>Seminar Data Science</h4>
          <p>17 Oktober 2025</p>
        </div>
        <div class="activity-item">
          <h4>Pelatihan Laravel</h4>
          <p>23 Oktober 2025</p>
        </div>
      </div>
    </div>

    <div class="report-box">
      <div>
        <h4>Laporan Penyalahgunaan</h4>
        <p style="font-size:13px;color:#555;">Laporkan penyalahgunaan sistem, konten tidak pantas, atau kendala teknis yang Anda alami</p>
      </div>
      <button>Buat Laporan</button>
    </div>
  </main>

  <script>
    const monthNames=["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
    let date=new Date();
    const monthYear=document.getElementById("monthYear");
    const calendarBody=document.getElementById("calendarBody");
    const renderCalendar=()=>{
      const month=date.getMonth(), year=date.getFullYear(), today=new Date();
      monthYear.textContent=`${monthNames[month]} ${year}`;
      const firstDay=new Date(year,month,1).getDay();
      const daysInMonth=new Date(year,month+1,0).getDate();
      let table="<table><tr><th>M</th><th>S</th><th>S</th><th>R</th><th>K</th><th>J</th><th>S</th></tr><tr>";
      let day=1;
      for(let i=0;i<6;i++){
        for(let j=0;j<7;j++){
          const cellIndex=i*7+j;
          if(cellIndex<(firstDay===0?6:firstDay-1)||day>daysInMonth){ table+="<td></td>"; }
          else {
            const cls=(day===today.getDate()&&month===today.getMonth()&&year===today.getFullYear())?"today":"";
            table+=`<td class="${cls}">${day}</td>`; day++;
          }
        }
        table+="</tr>";
        if(day>daysInMonth) break;
      }
      table+="</table>";
      calendarBody.innerHTML=table;
    };
    document.getElementById("prevMonth").onclick=()=>{ date.setMonth(date.getMonth()-1); renderCalendar(); };
    document.getElementById("nextMonth").onclick=()=>{ date.setMonth(date.getMonth()+1); renderCalendar(); };
    renderCalendar();
  </script>
  
</body>
</html>
