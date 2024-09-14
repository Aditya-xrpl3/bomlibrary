<?php
include '../includes/db.php';

// Pastikan ID buku tersedia dalam query string
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID buku tidak valid.");
}

$bookId = $_GET['id'];

// Ambil data buku berdasarkan ID dari database
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$bookId]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    die("Buku tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input
    $userName = isset($_POST['user_name']) ? trim($_POST['user_name']) : null;
    $bookingDate = isset($_POST['booking_date']) ? $_POST['booking_date'] : null;

    if (!$userName || !$bookingDate) {
        echo "<p>Nama peminjam dan tanggal booking tidak boleh kosong!</p>";
    } else {
        // Hitung tanggal pengembalian, yaitu 1 bulan dari tanggal peminjaman
        $returnDate = date('Y-m-d', strtotime("$bookingDate +1 month"));

        // Simpan data peminjaman ke tabel loans
        $stmt = $pdo->prepare("INSERT INTO loans (book_id, user_name, booking_date, return_date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$bookId, $userName, $bookingDate, $returnDate]);

        echo "<p>Booking berhasil!</p>";
        echo '<a href="index.php">Kembali ke Daftar Buku</a>';
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Buku</title>
    <link rel="stylesheet" href="../css/booking.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Booking Buku</h1>
        </div>
    </header>
    <div class="container">
        <p><strong>Judul Buku:</strong> <?= htmlspecialchars($book['title']) ?></p>
        <p><strong>Pengarang:</strong> <?= htmlspecialchars($book['author']) ?></p>
        <p><strong>Tahun Terbit:</strong> <?= htmlspecialchars($book['year']) ?></p>
        <p><strong>Sinopsis:</strong> <?= nl2br(htmlspecialchars($book['synopsis'])) ?></p>

        <form method="post">
            <label for="user_name">Nama Peminjam:</label>
            <input type="text" name="user_name" id="user_name" required>

            <label for="booking_date">Tanggal Booking:</label>
            <input type="date" name="booking_date" id="booking_date" required value="<?= date('Y-m-d') ?>">

            <button type="submit">Booking</button>
        </form>

        <a href="index.php">Kembali ke Daftar Buku</a>
    </div>
    <footer>
        <p>&copy; 2024 Perpustakaan</p>
    </footer>
</body>
</html>
