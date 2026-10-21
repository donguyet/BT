<?php
// 1. Tạo mảng $students gồm 3 sinh viên
$students = [
    ['name' => 'Nguyễn Văn An', 'midterm' => 7.0, 'final' => 8.0],
    ['name' => 'Trần Thị Bình', 'midterm' => 4.5, 'final' => 5.0],
    ['name' => 'Lê Hoàng Chi', 'midterm' => 8.5, 'final' => 9.0]
];
?>
<?php
// 2. Viết hàm calculateAverage() tính điểm trung bình
function calculateAverage(float $midterm, float $final): float {
    return ($midterm * 0.4) + ($final * 0.6); // Trọng số: 40% giữa kỳ, 60% cuối kỳ
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Bảng điểm sinh viên</title>
    <style>
        table { width: 60%; border-collapse: collapse; margin: 20px auto; font-family: Arial; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Bảng điểm tổng kết học phần</h2>
    <table>
        <tr>
            <th>STT</th>
            <th>Họ tên</th>
            <th>Giữa kỳ</th>
            <th>Cuối kỳ</th>
            <th>Điểm TB</th>
            <th>Kết quả</th>
        </tr>
        
        <?php 
        $stt = 1;
        // 3. Dùng foreach để duyệt mảng in ra bảng HTML
        foreach ($students as $student): 
            // Tính điểm TB bằng hàm đã viết ở Bước 3
            $avg = calculateAverage($student['midterm'], $student['final']);
            
            // 4. Xác định kết quả: Đạt nếu điểm trung bình >= 5
            $result = ($avg >= 5.0) ? 'Đạt' : 'Chưa đạt';
        ?>
            <tr>
                <td><?= $stt++ ?></td>
                <!-- 5. Mã hóa tên sinh viên bằng htmlspecialchars() trước khi in -->
                <td style="text-align: left;"><?= htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= $student['midterm'] ?></td>
                <td><?= $student['final'] ?></td>
                <td><strong><?= number_format($avg, 2) ?></strong></td>
                <td style="color: <?= $avg >= 5.0 ? 'green' : 'red' ?>;"><?= $result ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>