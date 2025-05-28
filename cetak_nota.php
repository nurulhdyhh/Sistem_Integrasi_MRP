<?php
// Nonaktifkan error display agar tidak mengganggu PDF
error_reporting(0);
ini_set('display_errors', 0);

// Mulai output buffering
ob_start();

require 'koneksi.php';
require 'dompdf/autoload.inc.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;

// 1. Ambil ID dan data pesanan
$id = $_GET['id'] ?? '';
if (!$id) {
    die("ID pesanan tidak diberikan."); // ini tidak boleh terjadi saat normal
}

// Query data pesanan
$q  = "SELECT o.*, p.email_pelanggan 
       FROM tbl_order o
       JOIN tbl_pelanggan p ON o.id_pelanggan = p.id_pelanggan
       WHERE o.id_order = '".mysqli_real_escape_string($db, $id)."'";
$res = mysqli_query($db, $q);
if (!$res || mysqli_num_rows($res) === 0) {
    die("Pesanan tidak ditemukan.");
}
$data = mysqli_fetch_assoc($res);

// Query detail produk
$q2  = "SELECT p.*, d.jml_order 
        FROM tbl_detail_order d 
        JOIN tbl_produk p ON d.id_produk = p.id_produk 
        WHERE d.id_order = '".mysqli_real_escape_string($db, $id)."'";
$res2 = mysqli_query($db, $q2);

// 2. Bangun HTML nota
$total = 0;
$html  = '<!DOCTYPE html><html><head><meta charset="UTF-8"><style>
    .nota-container { margin:50px auto; padding:30px; max-width:800px; border:2px solid #000; background:#fff; }
    .nota-header { text-align:center; margin-bottom:50px; }
    .nota-header h3, .nota-header h5 { margin:0; }
    .nota-header h5 { margin-top:5px; font-weight:normal; }
    .info-section { margin-top:20px; }
    .info-section div { margin-bottom: 10px; }
    .info-section .left { width:48%; display:inline-block; vertical-align: top; }
    .info-section .right { width:48%; display:inline-block; vertical-align: top; text-align:right; }
    table { width:100%; border-collapse:collapse; margin-top:20px; }
    table th, table td { border:1px solid #000; padding:8px; text-align:center; }
    .total { margin-top:15px; font-weight:bold; }
    .text-left { text-align:left; }
    .signature-container { text-align:right; margin-top:40px; }
</style></head><body>';

$html .= '<div class="nota-container">';
$html .= '<div class="nota-header"><h3>MediStore</h3><h5>Laporan Belanja Anda</h5></div>';

// Info pelanggan menggunakan div
$html .= '<div class="info-section">
    <div class="left">
        <p><strong>User ID:</strong> '.htmlspecialchars($data['id_pelanggan']).'</p>
        <p><strong>Nama:</strong> '.htmlspecialchars($data['nm_penerima']).'</p>
        <p><strong>Alamat:</strong> '.nl2br(htmlspecialchars($data['alamat'])).'</p>
        <p><strong>No HP:</strong> '.htmlspecialchars($data['telp']).'</p>
    </div>
    <div class="right">
        <p><strong>Tanggal:</strong> '.date("d-m-Y", strtotime($data['tgl_order'])).'</p>
        <p><strong>ID Paypal:</strong> '.htmlspecialchars($data['paypal_id'] ?: '-').'</p>
        <p><strong>Nama Bank:</strong> '.htmlspecialchars($data['nama_bank'] ?: '-').'</p>
        <p><strong>Cara Bayar:</strong> '.htmlspecialchars($data['metode_bayar'] ?: 'Prepaid').'</p>
    </div>
</div>';

// Tabel produk
$html .= '<table><thead><tr>
    <th>No.</th><th>Nama Produk</th><th>Jumlah</th><th>Harga</th>
</tr></thead><tbody>';

$no = 1;
mysqli_data_seek($res2, 0);
while ($r = mysqli_fetch_assoc($res2)) {
    $sub = $r['harga'] * $r['jml_order'];
    $total += $sub;
    $html .= '<tr>
        <td>'.$no++.'</td>
        <td>'.htmlspecialchars($r['nm_produk']).' '.htmlspecialchars($r['id_produk']).'</td>
        <td>'.$r['jml_order'].'</td>
        <td>Rp'.number_format($r['harga'],0,',','.').'</td>
    </tr>';
}
$html .= '</tbody></table>';

// Total & Pajak
$pajak = $total * 0.10;
$total_belanja = $total + $pajak;
$html .= '<div class="total text-left">
    Total (incl. pajak 10%): <strong>Rp '.number_format($total_belanja,0,',','.').'</strong>
</div>';

// Tanda tangan
$html .= '<div class="signature-container">
    <p>TANDA TANGAN TOKO</p>
    <img src="http://localhost/MediStore/assets/img/icon/ttd.png" width="150">

</div>';

$html .= '</div></body></html>';

// 3. Generate PDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4','portrait');
$dompdf->render();
$pdfString = $dompdf->output();

// 4. Kirim email dengan attachment
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'alkesaofficial@gmail.com';
    $mail->Password   = 'kqmfwxyqhcwstcrs';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('alkesaofficial@gmail.com','MediStore');
    $mail->addAddress($data['email_pelanggan'],$data['nm_penerima']);
    $mail->isHTML(true);
    $mail->Subject = 'Nota Transaksi Anda - MediStore';
    $mail->Body    = "
      Halo <b>{$data['nm_penerima']}</b>,<br><br>
      Terima kasih! Lampiran PDF nota transaksi ada di email ini.<br><br>
      Salam,<br><b>MediStore</b>
    ";
    $mail->addStringAttachment($pdfString, "nota-transaksi-{$id}.pdf");
    $mail->send();
    unlink($pdfPath);
    echo "<script>alert('PDF berhasil dikirim ke email!'); window.location='viewTransaksi.php';</script>";
} catch (Exception $e) {
    echo "Gagal kirim email: {$mail->ErrorInfo}";
}   

// 5. Bersihkan buffer dan kirim PDF ke browser
if (ob_get_length()) {
    ob_end_clean();
}
$dompdf->stream("nota-transaksi-{$id}.pdf", ["Attachment" => 1]);
exit;
?>
