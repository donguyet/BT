<?php
// Khởi tạo các biến lưu trữ dữ liệu form và thông báo lỗi
$errors = [];
$result = null;
$data = [
    'name'  => '',
    'cc'    => '',
    'mid'   => '',
    'final' => ''
];

// Hàm kiểm tra điểm hợp lệ từ 0 đến 10
function isValidScore($score): bool {
    return is_numeric($score) && $score >= 0 && $score <= 10;
}

// Hàm tính điểm tổng kết theo trọng số: 10% CC, 30% GK, 60% CK
function finalScore(float $cc, float $mid, float $final): float {
    return ($cc * 0.10) + ($mid * 0.30) + ($final * 0.60);
}

// Xử lý khi người dùng bấm nút gửi form (phương thức POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['name']  = trim($_POST['name'] ?? '');
    $data['cc']    = trim($_POST['cc'] ?? '');
    $data['mid']   = trim($_POST['mid'] ?? '');
    $data['final'] = trim($_POST['final'] ?? '');

    if ($data['name'] === '') {
        $errors['name'] = 'Vui lòng nhập họ tên sinh viên.';
    }
    if ($data['cc'] === '' || !isValidScore($data['cc'])) {
        $errors['cc'] = 'Điểm chuyên cần phải là số từ 0 đến 10.';
    }
    if ($data['mid'] === '' || !isValidScore($data['mid'])) {
        $errors['mid'] = 'Điểm giữa kỳ phải là số từ 0 đến 10.';
    }
    if ($data['final'] === '' || !isValidScore($data['final'])) {
        $errors['final'] = 'Điểm cuối kỳ phải là số từ 0 đến 10.';
    }

    if (empty($errors)) {
        $ccVal = (float)$data['cc'];
        $midVal = (float)$data['mid'];
        $finalVal = (float)$data['final'];

        $total = finalScore($ccVal, $midVal, $finalVal);

        if ($total >= 8.0) {
            $rank = 'Giỏi';
        } elseif ($total >= 6.5) {
            $rank = 'Khá';
        } elseif ($total >= 5.0) {
            $rank = 'Trung bình';
        } else {
            $rank = 'Chưa đạt';
        }

        $result = [
            'total' => $total,
            'rank'  => $rank
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Máy tính điểm học phần</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 480px;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            color: #333333;
            margin-bottom: 25px;
            font-size: 1.4rem;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #555555;
            font-size: 0.95rem;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px 12px;
            box-sizing: border-box;
            border: 1px solid #dcdcdc;
            border-radius: 6px;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s;
            cursor: text;
        }

        input[type="text"]:focus {
            border-color: #7c90db;
        }

        .error {
            color: #d9534f;
            font-size: 0.85rem;
            margin-top: 4px;
            display: block;
        }

        button {
            width: 100%;
            background-color: #7c90db;
            color: white;
            padding: 11px 15px;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-top: 10px;
        }

        button:hover {
            background-color: #657ac9;
        }

        button:active {
            background-color: #5364b0;
        }

        .result {
            margin-top: 20px;
            padding: 15px;
            background-color: #f0f4f8;
            border-left: 4px solid #7c90db;
            border-radius: 4px;
        }

        .result h3 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #333333;
            font-size: 1.05rem;
        }

        .result p {
            margin: 6px 0;
            color: #444444;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Máy tính điểm học phần</h2>
    <form method="post">
        <!-- Họ tên -->
        <div class="form-group">
            <label>Họ và tên sinh viên:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8') ?>">
            <?php if (isset($errors['name'])): ?>
                <span class="error"><?= $errors['name'] ?></span>
            <?php endif; ?>
        </div>

        <!-- Điểm chuyên cần -->
        <div class="form-group">
            <label>Điểm chuyên cần (10%):</label>
            <input type="text" name="cc" value="<?= htmlspecialchars($data['cc'], ENT_QUOTES, 'UTF-8') ?>">
            <?php if (isset($errors['cc'])): ?>
                <span class="error"><?= $errors['cc'] ?></span>
            <?php endif; ?>
        </div>

        <!-- Điểm giữa kỳ -->
        <div class="form-group">
            <label>Điểm giữa kỳ (30%):</label>
            <input type="text" name="mid" value="<?= htmlspecialchars($data['mid'], ENT_QUOTES, 'UTF-8') ?>">
            <?php if (isset($errors['mid'])): ?>
                <span class="error"><?= $errors['mid'] ?></span>
            <?php endif; ?>
        </div>

        <!-- Điểm cuối kỳ -->
         <div class="form-group">
            <label>Điểm cuối kỳ (60%):</label>
            <input type="text" name="final" value="<?= htmlspecialchars($data['final'], ENT_QUOTES, 'UTF-8') ?>">
            <?php if (isset($errors['final'])): ?>
                <span class="error"><?= $errors['final'] ?></span>
            <?php endif; ?>
        </div>

        <button type="submit">Tính điểm tổng kết</button>
    </form>

    <!-- Hiển thị kết quả -->
    <?php if ($result !== null): ?>
        <div class="result">
            <h3>Kết quả tổng kết</h3>
            <p><strong>Họ tên:</strong> <?= htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Điểm tổng kết:</strong> <?= number_format($result['total'], 2) ?></p>
            <p><strong>Xếp loại:</strong> <?= $result['rank'] ?></p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>