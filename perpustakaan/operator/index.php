<?php
include '../includes/db.php';

// Ambil data buku dari database
$stmtBooks = $pdo->query("SELECT * FROM books");
$books = $stmtBooks->fetchAll(PDO::FETCH_ASSOC);

// Ambil data peminjaman dari database
$stmtLoans = $pdo->query("SELECT l.*, b.title AS book_title FROM loans l JOIN books b ON l.book_id = b.id");
$loans = $stmtLoans->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Operator</title>
    <link rel="stylesheet" href="../css/operator_style.css">
</head>
<body>
    <header>
        <div class="container">
            <!-- <h1>Dashboard Operator</h1> -->
            <nav>
                <a href="../operator/add.php">Tambah Buku</a>
                <a href="../operator/index.php">Daftar Buku</a>
                <a href="../operator/loans.php">Daftar Peminjaman</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <!-- Daftar Buku -->
        <h2>Daftar Buku</h2>
        <table>
            <tr>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Tahun Terbit</th>
                <th>Kuantitas</th>
                <th>Aksi</th>
            </tr>
            <?php if ($books && count($books) > 0): ?>
                <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= htmlspecialchars($book['title']) ?></td>
                    <td><?= htmlspecialchars($book['author']) ?></td>
                    <td><?= htmlspecialchars($book['year']) ?></td>
                    <td><?= isset($book['quantity']) ? htmlspecialchars($book['quantity']) : 'N/A'; ?></td>
                    <td>
                    <a href="../operator/edit.php?id=<?= htmlspecialchars($book['id']) ?>">Edit</a> |
                    <a href="../operator/delete.php?id=<?= htmlspecialchars($book['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">Hapus</a>
                    </td>

                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Tidak ada buku untuk ditampilkan.</td>
                </tr>
            <?php endif; ?>
        </table>

        <!-- Daftar Peminjaman -->
        <!-- <h2>Daftar Peminjaman</h2>
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
                    <td><?= htmlspecialchars($loan['book_title']) ?></td>
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
    </div> -->

    <footer>
        <p>&copy; 2024 Perpustakaan</p>
    </footer>
</body>
</html>
