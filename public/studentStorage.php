<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['students']) || empty($_SESSION['students'])) {
    $_SESSION['students'] = [
        ['id' => 1, 'name' => 'John Doe'],
        ['id' => 2, 'name' => 'Jane Smith']
    ];
}


class StudentStorage {
    public function getAllStudents() {
        return $_SESSION['students'];
    }

    public function addStudent($student) {
        $_SESSION['students'][] = $student;
    }

    public function updateStudent($id, $data) {
        foreach ($_SESSION['students'] as &$student) {
            if ($student['id'] == $id) {
                $student = array_merge($student, $data);
                return true;
            }
        }
        return false;
    }

    public function deleteStudent($id) {
        foreach ($this->students as $key => $student) {
            if ($student['id'] == $id) {
                unset($this->students[$key]);
                return true;
            }
        }
        return false;
    }
}
