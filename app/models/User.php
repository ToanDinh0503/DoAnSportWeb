<?php
class User {
    private $conn;
    private $table_name = "users";

    // Các thuộc tính của người dùng
    public $id;
    public $username;
    public $password;
    public $email;
    public $ho_ten;
    public $so_dien_thoai;
    public $dia_chi;
    public $role;
    public $trang_thai;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        if (!$db) {
            throw new Exception("Database connection is required");
        }
        $this->conn = $db;
    }

    // Thêm người dùng mới
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                  (username, password, email, ho_ten, so_dien_thoai, dia_chi, role, trang_thai)
                  VALUES (:username, :password, :email, :ho_ten, :so_dien_thoai, :dia_chi, :role, :trang_thai)";

        $stmt = $this->conn->prepare($query);

        // Sanitize và bind giá trị
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->ho_ten = htmlspecialchars(strip_tags($this->ho_ten));
        $this->so_dien_thoai = htmlspecialchars(strip_tags($this->so_dien_thoai));
        $this->dia_chi = htmlspecialchars(strip_tags($this->dia_chi));
        $this->role = htmlspecialchars(strip_tags($this->role));
        $this->trang_thai = htmlspecialchars(strip_tags($this->trang_thai));

        // Bind giá trị
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", password_hash($this->password, PASSWORD_BCRYPT)); // Mã hóa mật khẩu
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":ho_ten", $this->ho_ten);
        $stmt->bindParam(":so_dien_thoai", $this->so_dien_thoai);
        $stmt->bindParam(":dia_chi", $this->dia_chi);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":trang_thai", $this->trang_thai);

        return $stmt->execute();
    }

    // Lấy tất cả người dùng
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Cập nhật thông tin người dùng
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                  SET username = :username, password = :password, email = :email, ho_ten = :ho_ten, 
                      so_dien_thoai = :so_dien_thoai, dia_chi = :dia_chi, role = :role, trang_thai = :trang_thai,
                      updated_at = CURRENT_TIMESTAMP
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize và bind giá trị
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->ho_ten = htmlspecialchars(strip_tags($this->ho_ten));
        $this->so_dien_thoai = htmlspecialchars(strip_tags($this->so_dien_thoai));
        $this->dia_chi = htmlspecialchars(strip_tags($this->dia_chi));
        $this->role = htmlspecialchars(strip_tags($this->role));
        $this->trang_thai = htmlspecialchars(strip_tags($this->trang_thai));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind giá trị
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", password_hash($this->password, PASSWORD_BCRYPT)); // Mã hóa mật khẩu
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":ho_ten", $this->ho_ten);
        $stmt->bindParam(":so_dien_thoai", $this->so_dien_thoai);
        $stmt->bindParam(":dia_chi", $this->dia_chi);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":trang_thai", $this->trang_thai);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    // Xóa người dùng
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    // Tìm kiếm người dùng
    public function search($searchTerm) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username LIKE :searchTerm OR email LIKE :searchTerm";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':searchTerm', "%" . $searchTerm . "%");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
