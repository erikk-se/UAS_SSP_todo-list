<?php
class User
{
    public int $id;
    public string $email;
    public string $password;

    public function __construct(int $id, string $email, string $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
    }
}
class Task
{
    public int $id;
    public string $name;
    public string $status;

    public function __construct(int $id, string $name, string $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
    }
}
class GlobalResponse
{
    public int $status;
    public string $message;
    public $data;

    public function __construct(int $status, string $message, $data)
    {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
    }
}
class Controller
{
    private $koneksi;
    private $dbHost = "localhost";
    private $dbName = "todo_list";
    private $dbUser = "root";
    private $dbPass = "";
    private $tblUser = "user";
    private $tblTask = "task";

    public function __construct()
    {
        $this->koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName);
        if (!$this->koneksi) {
            die("Koneksi Gagal : " . mysqli_connect_error());
        }
    }

    public function Login(string $email, string $password): GlobalResponse
    {
        if (isset($email) && isset($password)) {
            $sql = "SELECT * FROM $this->tblUser WHERE `email` = '$email' AND `password` = md5('$password')";
            $result = mysqli_query($this->koneksi, $sql);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $user = new User($row["id"], $row["email"], $row["password"]);
                $global = new GlobalResponse(200, "Login Success", $user);
                return $global;
            } else {
                return new GlobalResponse(400, "Email or Password incorrect", null);
            }
        } else {
            return new GlobalResponse(400, "Email or Password cant be null", null);
        }
    }
    public function validateEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
    public function Register(string $name, string $email, string $password, string $cpassword): GlobalResponse
    {

        if ($name == "") {
            return new GlobalResponse(400, "Name cant be null", null);
        }
        if ($email == "") {
            return new GlobalResponse(400, "Email cant be null", null);
        }
        if (!$this->validateEmail($email)) {
            return new GlobalResponse(400, "Email not valid", null);
        }
        if ($password == "") {
            return new GlobalResponse(400, "Password cant be null", null);
        }
        if ($cpassword == "") {
            return new GlobalResponse(400, "Confirm Password cant be null", null);
        }
        if ($cpassword != $password) {
            return new GlobalResponse(400, "Confirm Password not match", null);
        }
        $sql = "INSERT INTO $this->tblUser VALUES (null, '$name', '$email', md5('$password'))";
        $result = mysqli_query($this->koneksi, $sql);
        if ($result) {
            $global = new GlobalResponse(200, "Register Success", null);
            return $global;
        } else {
            return new GlobalResponse(400, "Register Failed", null);
        }
    }
    public function GetTasks(string $status = null)
    {
        $kondisi = "";
        if (isset($status)) {
            $kondisi = "WHERE status = " . $status;
        }
        $sql = "SELECT * FROM $this->tblTask " . $kondisi;
        $result = mysqli_query($this->koneksi, $sql);
        $tasks = array();
        while ($row = mysqli_fetch_array($result)) {
            $tasks[] = new Task($row['id'], $row['name'], $row['status']);
        }
        return $tasks;
    }
    public function CreateTask(string $id, string $name)
    {
        if ($name == "") {
            return new GlobalResponse(400, "Name cant be null", null);
        }
        $sql = "INSERT INTO $this->tblTask VALUES (null, '$name', 1)";
        if ($id != "") {
            $sql = "UPDATE $this->tblTask SET name = '$name' WHERE id = $id";
        }
        $result = mysqli_query($this->koneksi, $sql);
        if ($result) {
            if ($id != "")
                return new GlobalResponse(200, "Update Task Success", null);
            return new GlobalResponse(200, "Create Task Success", null);
        } else {
            if ($id != "")
                return new GlobalResponse(400, "Update Task Failed", null);
            return new GlobalResponse(400, "Create Task Failed", null);
        }
    }
    public function DeleteTask(string $id)
    {
        if ($id == "") {
            return new GlobalResponse(400, "Id cant be null", null);
        }
        $sql = "DELETE FROM $this->tblTask WHERE id = $id";
        $result = mysqli_query($this->koneksi, $sql);
        if ($result) {
            return new GlobalResponse(200, "Delete Task Success", null);
        } else {
            return new GlobalResponse(400, "Delete Task Failed", null);
        }
    }
    public function UpdateTask(string $id, string $status)
    {
        if ($id == "") {
            return new GlobalResponse(400, "Id cant be null", null);
        }
        if ($status == "") {
            return new GlobalResponse(400, "Status cant be null", null);
        }
        $sql = "UPDATE $this->tblTask SET status = $status WHERE id = $id";
        $result = mysqli_query($this->koneksi, $sql);
        if ($result) {
            return new GlobalResponse(200, "Update Task Success", null);
        } else {
            return new GlobalResponse(400, "Update Task Failed", null);
        }
    }

    // public function GetAllBooks(): array
    // {
    //     $all_result = array();
    //     $sql = "SELECT * FROM $this->bukuTable WHERE deleted_at IS NULL";
    //     $result = mysqli_query($this->koneksi, $sql);

    //     while ($row = mysqli_fetch_array($result)) {
    //         $all_result[] = new Books($row['id'], $row['nama'], $row['penulis'], $row['tanggal_terbit'], $row['deleted_at'] != null ? true : false);
    //     }

    //     return $all_result;
    // }

    // public function GetBookById(int $id): Books | null
    // {
    //     if ($id != 0) {
    //         $sql = "SELECT * FROM $this->bukuTable WHERE id = $id";
    //         $result = mysqli_query($this->koneksi, $sql);
    //         $row = mysqli_fetch_assoc($result);
    //         if (mysqli_num_rows($result) > 0) {
    //             return new Books($row['id'], $row['nama'], $row['penulis'], $row['tanggal_terbit'], $row['deleted_at'] != null ? true : false);
    //         } else {
    //             return null;
    //         }
    //     } else {
    //         return null;
    //     }
    // }

    // public function AddBook(string $nama, string $penulis, string $tanggal_terbit): GlobalResponse
    // {
    //     $sql = "INSERT INTO $this->bukuTable VALUES (null, '$nama', '$penulis', '$tanggal_terbit',now(),now(),null)";
    //     $result = mysqli_query($this->koneksi, $sql);
    //     if ($result) {
    //         $global = new GlobalResponse(200, "Add Book Success", null);
    //         return $global;
    //     } else {
    //         return new GlobalResponse(400, "Add Book Failed", null);
    //     }
    // }

    // public function UpdateBook(int $id, string $nama, string $penulis, string $tanggal_terbit): GlobalResponse
    // {
    //     $sql = "UPDATE $this->bukuTable SET nama = '$nama', penulis = '$penulis', tanggal_terbit = '$tanggal_terbit',updated_at=now() WHERE id = $id";
    //     $result = mysqli_query($this->koneksi, $sql);
    //     if ($result) {
    //         $global = new GlobalResponse(200, "Update Book Success", null);
    //         return $global;
    //     } else {
    //         return new GlobalResponse(400, "Update Book Failed", null);
    //     }
    // }

    // public function DeleteBook(int $id): GlobalResponse
    // {
    //     $sql = "UPDATE $this->bukuTable SET deleted_at=now() WHERE id = $id";
    //     $result = mysqli_query($this->koneksi, $sql);
    //     if ($result) {
    //         $global = new GlobalResponse(200, "Delete Book Success", null);
    //         return $global;
    //     } else {
    //         return new GlobalResponse(400, "Delete Book Failed", null);
    //     }
    // }
}

$controller = new Controller();
