<?php

namespace Classes;

use Abstracts\Entity;
use Utils\Helpers;
use Classes\Auth;
use mysqli;
use Classes\Permission;
use Utils\Env;
use Utils\Key;

class User extends Entity
{
    private $auth;

    public function __construct()
    {
        $this->auth = new Auth();
    }

    public function insertUser(String $parentId, String $name, String $lastname, String $email, String $pass, String $birthday, String $phone, String $address, $idRol, String $related = '')
    {
        global $db;
        $parentId = mysqli_real_escape_string(Helpers::connect(), $parentId);
        $name = mysqli_real_escape_string(Helpers::connect(), $name);
        $lastname = mysqli_real_escape_string(Helpers::connect(), $lastname);
        $email = mysqli_real_escape_string(Helpers::connect(), $email);
        $birthday = mysqli_real_escape_string(Helpers::connect(), $birthday);
        $pass = password_hash(($pass), PASSWORD_BCRYPT, ['cost' => 4]);
        $phone = mysqli_real_escape_string(Helpers::connect(), $phone);
        $related = mysqli_real_escape_string(Helpers::connect(), $related);
        $address = mysqli_real_escape_string(Helpers::connect(), $address);

        try {
            // Check if email already exists
            $exists_email = $db->query("SELECT * FROM users WHERE email = '$email'");
            /*  var_dump($exists_email);
            die(); */
            if ($exists_email->num_rows > 0) {
                return false; // Email already exists
            } else {
                // Insert user data into database
                $key = new Key();
                $id = $key->generate_uuid();
                $query = "INSERT INTO users (id, parent_id, name, lastname, email, password, birthday, phone, address, id_rol, related, active, created_at, updated_at) VALUES ('$id', '$parentId','$name', '$lastname', '$email', '$pass', '$birthday', '$phone', '$address', $idRol, '$related', 1, NOW(), NOW())";
                $sql = $db->query($query);
                if (!$sql) {
                    throw new \Exception(mysqli_error($db));
                }
                return $sql; // Return the query result
            }
        } catch (\Exception $e) {
            // Handle the exception (e.g., log it, display an error message)
            $error = error_log("Error inserting user: " . $e->getMessage());

            return $error;
        }
    }

    public function getUsersByRol($id_rol)
    {
        $query = "SELECT * FROM users WHERE id_rol= $id_rol; ";
        $users = Helpers::connect()->query($query);
        return isset($users) ? $users->fetch_all(MYSQLI_ASSOC) : null;
    }

    public function login(string $email, string $password)
    {
        $email = mysqli_real_escape_string(Helpers::connect(), $email);
        $user = Helpers::connect()->query("SELECT * FROM users WHERE email = '$email' AND active = 1");

        if ($user && $user->num_rows === 1) {
            $instance = $user->fetch_assoc();
            $verify = password_verify($password, $instance['password']);
            /*  var_dump($instance);
            die(); */
            if ($verify) {
                $id = $instance['id'];
                $sql = "SELECT 
                        u.id AS user_id, 
                        u.name AS user_name, 
                        u.lastname AS user_lastname, 
                        r.id AS role_id, 
                        r.name AS role_name,
                        GROUP_CONCAT(p.name SEPARATOR ', ') AS permissions 
                    FROM users u
                    INNER JOIN rols r ON u.id_rol = r.id
                    INNER JOIN rols_permissions rp ON r.id = rp.id_rol
                    INNER JOIN permissions p ON rp.id_permission = p.id
                    WHERE u.id = '$id'
                    AND u.active = 1 
                    AND r.active = 1 
                    AND rp.active = 1 
                    AND p.active = 1
                    GROUP BY u.id, r.id
                    ORDER BY r.name;
                    ";
                /* echo $sql;
                die(); */
                $permissions = Helpers::connect()->query($sql);
                $data = $permissions->fetch_assoc();
                $tokenData = [
                    "id" => $instance['id'],
                    "name" => $instance['name'],
                    "lastname" => $instance['lastname'],
                    "email" => $instance['email'],
                    "parent_id" => $instance['parent_id'],
                    "permissions" => $data
                ];
                // Generar el token usando el método getToken().
                /*  var_dump($tokenData);
                die(); */
                $token = $this->auth->getToken($tokenData);

                return [
                    "userId" => $instance['id'], // Devolviendo el id del usuario.
                    "token" => $token,
                ];
            }
        }

        // En caso de fallo, devolver false.
        return false;
    }

    public function getUsersbyParentId(int $id)
    {
        $sql = "SELECT * FROM users where parentId = $id and active=1";
        $users = Helpers::connect()->query($sql);
        return isset($users) ? $users->fetch_all(MYSQLI_ASSOC) : null;
    }

    public function createUser(string $parent_id, string $name, string $lastname, string $email, string $pass, $birthday)
    {
        global $db;
        $name = mysqli_real_escape_string(Helpers::connect(), $name);
        $lastname = mysqli_real_escape_string(Helpers::connect(), $lastname);
        $birthday = mysqli_real_escape_string(Helpers::connect(), $birthday);
        $email = mysqli_real_escape_string(Helpers::connect(), $email);
        $pass = password_hash(($pass), PASSWORD_BCRYPT, ['cost' => 4]);
        $birthday = mysqli_real_escape_string(Helpers::connect(), $birthday);

        $key = new Key();
        $id = $key->generate_uuid();

        $query = "INSERT INTO users(id, parent_id, name, lastname, email, password, birthday, active, created_at, updated_at) 
        values('$id', '$parent_id', '$name', '$lastname', '$email', '$pass', '$birthday', 1, NOW(), NOW());";
        /* echo($query);
        die(); */
        try {
            // Check if email already exists
            $exists_email = Helpers::connect()->query("SELECT * FROM users WHERE email = '$email'");
            if ($exists_email->num_rows > 0) {
                return false; // Email already exists
            } else {
                // Insert user data into database
                $sql = $db->query($query);

                if (!$sql) {
                    throw new \Exception(mysqli_error($db));
                }
                return $sql; // Return the query result
            }
        } catch (\Exception $e) {
            // Handle the exception (e.g., log it, display an error message)
            $error = error_log("Error inserting user: " . $e->getMessage());

            return $error;
        }
    }

    private function getUserByEmail(string $email)
    {
        $email = mysqli_real_escape_string(Helpers::connect(), $email);
        $user = Helpers::connect()->query("SELECT * FROM users WHERE email = '$email'");
        if ($user && $user->num_rows == 1) {
            return $user->fetch_assoc();
        } else {
            return null;
        }
    }

    public function setRandomId()
    {
        $id = new Key();
        $data = $id->generate_uuid();
        return $data;
    }

    public function resetPasswordToBirthdate($userId)
    {
        try {
            // (Mejor usa prepared statements; aquí mantengo tu patrón)
            $userIdEsc = Helpers::connect()->real_escape_string($userId);

            // 1) Obtener fecha de nacimiento
            $query = "SELECT birthday FROM users WHERE id = '$userIdEsc'";
            try {
                $data = Helpers::myQuery($query);
            } catch (\Exception $e) {
                error_log("Error: " . $e->getMessage());
                return ['error' => 'Error al ejecutar la consulta (SELECT)'];
            }

            if (empty($data) || empty($data[0]['birthday'])) {
                return ['error' => 'Usuario no encontrado o sin fecha de nacimiento'];
            }

            // 2) Formatear ddmmyy
            $ts = strtotime($data[0]['birthday']);
            if ($ts === false) {
                return ['error' => 'Fecha de nacimiento inválida'];
            }
            $newPassword = date('dmy', $ts);

            // Cost por default (mejor que 4)
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

            // 3) Actualizar password
            $updateQuery = "
            UPDATE users
            SET password = '$hashedPassword', updated_at = NOW()
            WHERE id = '$userIdEsc'
        ";

            try {
                $result = Helpers::myQuery($updateQuery); // ahora NO revienta
                // $result['affected_rows'] disponible por el cambio en myQuery
                if (isset($result['affected_rows']) && $result['affected_rows'] > 0) {
                    return ['ok' => true, 'new_password_plain' => $newPassword]; // quítalo si no quieres regresarlo
                }
                return ['error' => 'No se actualizó ninguna fila (¿ID inexistente?)'];
            } catch (\Exception $e) {
                error_log("Error: " . $e->getMessage());
                return ['error' => 'Error al ejecutar la consulta (UPDATE)'];
            }
        } catch (\Exception $e) {
            error_log("Error resetting password: " . $e->getMessage());
            return ['error' => 'Error interno al resetear contraseña'];
        }
    }
}
