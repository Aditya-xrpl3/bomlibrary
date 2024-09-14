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
    <title>Detail Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/detail.css">
</head>
<body>
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3">Detail Buku</h1>

            <!-- Form pencarian di header -->
            <form action="index.php" method="GET" class="d-flex">
                <input class="form-control me-2" type="search" name="search" placeholder="Cari buku..." aria-label="Search">
                <button class="btn btn-light" type="submit">Cari</button>
            </form>
        </div>
    </header>

    <div class="container my-4">
        <div class="row">
            <div class="col-md-4">
                <div class="book-cover">
                    <?php if (!empty($book['cover_image'])): ?>
                        <img src="../uploads/<?= htmlspecialchars($book['cover_image']) ?>" alt="Cover Buku" class="img-fluid">
                    <?php else: ?>
                        <p class="text-muted">Cover buku tidak tersedia.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-8">
                <div class="book-info">
                    <h2><?= htmlspecialchars($book['title']) ?></h2>
                    <p><strong>Pengarang:</strong> <?= htmlspecialchars($book['author']) ?></p>
                    <p><strong>Tahun Terbit:</strong> <?= htmlspecialchars($book['year']) ?></p>
                    <p><strong>Sinopsis:</strong> <?= htmlspecialchars($book['synopsis']) ?></p>

                    <form action="booking.php?id=<?= $bookId ?>" method="post" class="mt-4">
                        <button type="submit" class="btn btn-primary">Booking Buku Ini</button>
                    </form>
                    <a href="index.php" class="btn btn-secondary mt-2">Kembali ke Daftar Buku</a>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-4">
        <p>&copy; 2024 Perpustakaan</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
