<?php
include '../includes/db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID buku tidak valid.");
}

$bookId = $_GET['id'];

// Hapus buku dari database
$stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
$stmt->execute([$bookId]);

echo "<p>Buku berhasil dihapus!</p>";
echo '<a href="index.php">Kembali ke Daftar Buku</a>';
?>
