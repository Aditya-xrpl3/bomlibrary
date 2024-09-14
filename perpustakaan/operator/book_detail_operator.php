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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku - Operator</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Detail Buku</h1>
        </div>
    </header>
    <div class="container">
        <h2><?= htmlspecialchars($book['title']) ?></h2>
        <p><strong>Pengarang:</strong> <?= htmlspecialchars($book['author']) ?></p>
        <p><strong>Tahun Terbit:</strong> <?= htmlspecialchars($book['year']) ?></p>
        <p><strong>Sinopsis:</strong> <?= htmlspecialchars($book['synopsis']) ?></p>

        <!-- Tombol Edit dan Hapus hanya untuk operator -->
        <a href="edit_book.php?id=<?= $bookId ?>">Edit Buku</a> |
        <a href="delete_book.php?id=<?= $bookId ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">Hapus Buku</a>

        <br><br>
        <a href="index.php">Kembali ke Daftar Buku</a>
    </div>
    <footer>
        <p>&copy; 2024 Perpustakaan</p>
    </footer>
</body>
</html>
