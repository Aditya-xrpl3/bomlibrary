<?php
include '../includes/db.php';

// Ambil data peminjaman dari database
$stmt = $pdo->query("SELECT * FROM loans");
$loans = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peminjaman</title>
    <link rel="stylesheet" href="../css/daftar_peminjam.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Daftar Peminjaman</h1>
            <nav>
                <a href="index.php">Kembali ke Dashboard</a>
            </nav>
        </div>
    </header>
    <div class="container">
        <h1>Daftar Peminjaman Buku</h1>
        <table>
            <tr>
                <th>Nama Peminjam</th>
                <th>Judul Buku</th>
                <th>Tanggal Booking</th>
                <th>Tanggal Pengembalian</th>
            </tr>
            <?php if ($loans && count($loans) > 0): ?>
                <?php foreach ($loans as $loan): ?>
                <tr>
                    <td><?= htmlspecialchars($loan['user_name']) ?></td>
                    <td>
                        <?php
                        $bookStmt = $pdo->prepare("SELECT title FROM books WHERE id = ?");
                        $bookStmt->execute([$loan['book_id']]);
                        $book = $bookStmt->fetch(PDO::FETCH_ASSOC);
                        echo htmlspecialchars($book['title']);
                        ?>
                    </td>
                    <td><?= htmlspecialchars($loan['booking_date']) ?></td>
                    <td><?= htmlspecialchars($loan['return_date']) ?: 'Belum dikembalikan' ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Tidak ada peminjaman untuk ditampilkan.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
    <footer>
        <p>&copy; 2024 Perpustakaan</p>
    </footer>
</body>
</html>
