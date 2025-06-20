<?php
    class StudentController {
        private $storage = [];

        public function __construct($storage) {
             $this->storage = $storage;
        }

        public function getAllStudents(Request $request, Response $response) {
            $response->send(200, $this->storage->getAllStudents());
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
            $studentLength = count($this->storage->getAllStudents());
            $newStudent = [
                'id' => $this->storage->getAllStudents()[$studentLength - 1]['id'] + 1, 
                'name' => $data['name']
            ];
            $this->storage->addStudent($newStudent);

            $response->send(200,
            ['message' => 'Student created successfully']);
            return $response;
        }

        public function updateStudent(Request $request, Response $response) {
            // Logic to update a student by ID
            $data = $request->getBody();
            $id = $request->getQueryParams()['id'] ?? null;
           
            if (!$id || !$data) {
                $response->send(400, ['message' => 'Invalid request']);
                return $response;
            }

            $this->storage->updateStudent($id, $data);

            $response->send(200,['message' => 'Student updated successfully']);
            return $response;
        }

        public function deleteStudent(Request $request, Response $response) {
            // Logic to delete a student by ID
            $id = $request->getQueryParams()['id'] ?? null;
            $this->storage->deleteStudent($id);
            $response->send(200,['message' => 'Student deleted successfully']);
            return $response;
        }
    }
?>