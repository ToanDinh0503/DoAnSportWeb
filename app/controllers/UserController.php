<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/NguoiDung.php';

class UserController extends BaseController {
    private $nguoiDungModel;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        parent::__construct();
        $this->nguoiDungModel = new NguoiDung($this->db);
    }

    public function index($page = 1) {
        try {
            $limit = 10;
            $users = $this->nguoiDungModel->getAllUsers($page, $limit);
            $totalUsers = $this->nguoiDungModel->getTotalUsers();
            $totalPages = ceil($totalUsers / $limit);

            return [
                'users' => $users,
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'totalUsers' => $totalUsers
            ];
        } catch (Exception $e) {
            error_log("Error in UserController::index: " . $e->getMessage());
            return [
                'users' => [],
                'currentPage' => 1,
                'totalPages' => 0,
                'totalUsers' => 0
            ];
        }
    }

    public function getUserForEdit($id) {
        try {
            $user = $this->nguoiDungModel->getUser($id);
            return [
                'user' => $user
            ];
        } catch (Exception $e) {
            error_log("Error in UserController::getUserForEdit: " . $e->getMessage());
            return [
                'user' => null
            ];
        }
    }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') return;

        $email = $_POST['email'];
        $password = $_POST['password'];
        
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
            $stmt->execute([$email, $email]);
            $user = $stmt->fetch();

            if (!$user) {
                $_SESSION['login_error'] = 'Email không đúng hoặc không tồn tại !';
                header("Location: /WebbandoTT/dang-nhap");
                exit();
            }

            if (!password_verify($password, $user['password'])) {
                $_SESSION['login_error'] = 'Mật khẩu không chính xác !';
                header("Location: /WebbandoTT/dang-nhap");
                exit();
            }

            if ($user['trang_thai'] != 1) {
                $_SESSION['login_error'] = 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên để biết thông tin !';
                header("Location: /WebbandoTT/dang-nhap");
                exit();
            }

            $this->createUserSession($user);
            
            if ($user['role'] == 'admin') {
                header("Location: /WebbandoTT/admin/dashboard");
            } else {
                header("Location: /WebbandoTT/");
            }
            exit();

        } catch(PDOException $e) {
            $_SESSION['login_error'] = 'Có lỗi xảy ra, vui lòng thử lại sau';
            header("Location: /WebbandoTT/dang-nhap");
            exit();
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') return;

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $ho_ten = $_POST['ho_ten'];
        $so_dien_thoai = $_POST['so_dien_thoai'] ?? null;
        $dia_chi = $_POST['dia_chi'] ?? null;

        try {
            // Kiểm tra username và email tồn tại
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            if ($stmt->fetchColumn() > 0) {
                $_SESSION['register_error'] = 'Username hoặc email đã tồn tại !';
                header("Location: /WebbandoTT/dang-ky");
                exit();
            }

            // Thêm user mới với role mặc định là 'user'
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare(
                "INSERT INTO users (username, password, email, ho_ten, so_dien_thoai, dia_chi, role, trang_thai) 
                 VALUES (?, ?, ?, ?, ?, ?, 'user', 1)"
            );
            $stmt->execute([$username, $hashedPassword, $email, $ho_ten, $so_dien_thoai, $dia_chi]);

            $_SESSION['success'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
            header("Location: /WebbandoTT/dang-nhap");
            exit();

        } catch(PDOException $e) {
            $_SESSION['register_error'] = 'Có lỗi xảy ra, vui lòng thử lại sau';
            header("Location: /WebbandoTT/dang-ky");
            exit();
        }
    }

    private function createUserSession($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['ho_ten'] = $user['ho_ten'];
        $_SESSION['role'] = $user['role'];
    }

    public function logout() {
        session_destroy();
        header("Location: /WebbandoTT/dang-nhap");
        exit();
    }
}
?>
