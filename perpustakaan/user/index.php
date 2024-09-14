<?php
include '../includes/db.php';

// Cek apakah ada parameter pencarian dari user
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Jika ada pencarian, tambahkan query untuk memfilter buku berdasarkan judul
if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM books WHERE title LIKE ?");
    $stmt->execute(['%' . $search . '%']);
} else {
    // Ambil semua buku jika tidak ada pencarian
    $stmt = $pdo->query("SELECT * FROM books");
}

$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Jika hanya ada satu hasil pencarian, redirect ke halaman detail buku
if ($search && count($books) == 1) {
    header('Location: book_detail.php?id=' . $books[0]['id']);
    exit(); // Pastikan untuk menghentikan eksekusi setelah redirect
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/user_style.css">
</head>
<body>
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3">Daftar Buku</h1>

            <!-- Form pencarian -->
            <form action="index.php" method="GET" class="d-flex">
                <input class="form-control me-2" type="search" name="search" placeholder="Cari buku..." aria-label="Search" value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-light" type="submit">Cari</button>
            </form>
        </div>
    </header>

    <div class="container my-4">
        <div class="row">
            <?php if ($books && count($books) > 0): ?>
                <?php foreach ($books as $book): ?>
                <div class="col-md-3">
                    <div class="card book-card">
                        <div class="book-cover">
                            <?php if (!empty($book['cover_image'])): ?>
                                <img src="../uploads/<?= htmlspecialchars($book['cover_image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
                            <?php else: ?>
                                <div class="text-center p-4 bg-light">
                                    <p class="text-muted">Cover belum tersedia</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <h5 class="book-title">
                                <a href="book_detail.php?id=<?= htmlspecialchars($book['id']) ?>" class="text-decoration-none"><?= htmlspecialchars($book['title']) ?></a>
                            </h5>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center">Buku tidak ditemukan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-4">
        <p>&copy; 2024 Perpustakaan</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
