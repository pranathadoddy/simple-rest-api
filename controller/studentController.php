<?php
    class StudentController {
        private $students = [];

        public function __construct() {
             $this->students = [
                ['id' => 1, 'name' => 'John Doe'],
                ['id' => 2, 'name' => 'Jane Smith']
            ];
        }

        public function getAllStudents(Request $request, Response $response) {
            $response->send(200, $this->students);
            return $response;
        }

        public function getStudentById(Request $request, 
        Response $response, $id) {
            // Logic to fetch a student by ID
            $student = ['id' => $id, 'name' => 'John Doe'];
            $response->send(200,$student);
            return $response;
        }

        public function createStudent(Request $request, 
        Response $response) {
            /*
            { "name": "New Student" }
            */
            // Logic to create a new student
            $data = $request->getBody();
            $studentLength = count($this->students);
            $newStudent = [
                'id' => $this->students[$studentLength - 1]['id'] + 1, 
                'name' => $data['name']
            ];
            $this->students[] = $newStudent;

            $response->send(200,
            ['message' => 'Student created successfully']);
            return $response;
        }

        public function updateStudent(Request $request, Response $response) {
            // Logic to update a student by ID
            $data = $request->getBody();
            $id = $request->getQueryParams()['id'] ?? null;
            $studentIndex = array_search($id, 
            array_column($this->students, 
            'id'));

            if ($studentIndex === false) {
                $response->send(404, ['message' => 'Student not found']);
                return $response;
            }

            $this->students[$studentIndex]['name'] = $data['name'] ?? 
            $this->students[$studentIndex]['name'];

            $response->send(200,['message' => 'Student updated successfully']);
            return $response;
        }

        public function deleteStudent(Request $request, Response $response) {
            // Logic to delete a student by ID

            $id = $request->getQueryParams()['id'] ?? null;
            $studentIndex = array_search($id, 
            array_column($this->students, 'id'));

            if ($studentIndex === false) {
                $response->send(404, ['message' => 'Student not found']);
                return $response;
            }
            unset($this->students[$studentIndex]);
            $response->send(200,['message' => 'Student deleted successfully']);
            return $response;
        }
    }
?>