<?php
declare(strict_types=1);
session_start();
    require "vendor/autoload.php";
const STUDENTS = 200;
const PASSWORD = 'pbkdf2_sha256$216000$I0OGuUPqWu24$WvNdj16aD9L+97hC...';
const CHAIRPERSON = '1, 0, 1, 0, 0';
const STUDENT_CODE = '';
$_SESSION['last_user_id'] = 1;
    $faker = \Faker\Factory::create('en_PH');

//password: pbkdf2_sha256$216000$I0OGuUPqWu24$WvNdj16aD9L+97hC...
// CREATE COLLEGE (id, collegeName, collegeDesc)
// CREATE DEPARTMENT (id, courseName, collegeId_id, chairperson_id, courseDesc)

// Chairperson (cpersonUser_id) 2
// Faculty (
//     facultyUser_id, facultyID, facultyWorkStatus, facultyGender, facultyCivilStatus,
//     facultyCitizenship, facultyContact, facultyIn, facultyOut, collegeID_id, departmentID_id,
// )
// blocksection (id, blockYear, blockCourse, curryear, college_id, adviser_id)
// studentinfo (
//     studentUser_id, student_ID, studentGender,
//     studentCitizenship, studentCivilStatus, studentContact,
//     studentRegStatus, studentType, studentCourse, studentYearLevel,
//     collegeID_id, departmentID_id, studentSection_id
// )\
// CREATE USERS (
//     id, password, email, firstName,
//     middleName, lastName, is_active,
//     is_admin, is_chairperson, is_faculty, is_student) 500 students, 50 faculty
//function create_college() {
//    echo "INSERT INTO crs_college (id, collegeName, collegeDesc) VALUES (1, 'CET', 'College of Engineering') <br>";
//}
//    for ($i=0; $i<2; $i++) {
//        $data = "( %d, '%s', '%s', '%s', '%s', '%s', 1, 0, 1, 0, 0), <br>";
//        echo sprintf($data, $i+2,
//            PASSWORD,
//            str_replace(['example.com', 'example.org', 'example.net'], 'plm.edu.ph', $faker->safeEmail()),
//            $faker->firstName(),
//            strtoupper($faker->randomLetter()),
//            $faker->lastName(),
//        );
//    }
function create_college() {
    echo "INSERT INTO crs_college (id, collegeName, collegeDesc) VALUES (1, 'CET', 'College of Engineering') <br>";
}
function create_chairperson() {
    $id = $_SESSION['last_user_id'] + 1;
    echo "INSERT INTO crs_user (id, password, email, firstName, middleName, lastName, is_active, is_admin, is_chairperson, is_faculty, is_student) 
VALUES ($id, 'pbkdf2_sha256$216000$I0OGuUPqWu24$WvNdj16aD9L+97hC...', 'cmmolina@plm.edu.ph', 'C', 'M', 'Molina',".CHAIRPERSON.")<br>";
    echo "INSERT INTO crs_chairpersoninfo (cpersonUser_id) VALUES ($id) <br>";
    $_SESSION['last_user_id']++;
}

function create_department() {
    echo "INSERT INTO crs_department (courseName, collegeID_id, chairperson_id, courseDesc) VALUES ('BSIT', 1, (SELECT cpersonUser_id from crs_chairpersoninfo LIMIT 1), 'Bachelor of Science in Information Technology') <BR>";
    echo "INSERT INTO crs_department (courseName, collegeID_id, chairperson_id, courseDesc) VALUES ('BSEE', 1, (SELECT cpersonUser_id from crs_chairpersoninfo LIMIT 1), 'Bachelor of Science in Electrical Engineering') <BR>";
}

$create_faculty = function (int $number) use ($faker, $LAST_USER_ID){
    echo "INSERT INTO crs_user (id, password, email, firstName, middleName, lastName, is_active, is_admin, is_chairperson, is_faculty, is_student) VALUES <br>";
    $id = $_SESSION['last_user_id'];
    for ($i=0; $i < $number; $i++) {
        $data = "( %d, '%s', '%s', '%s', '%s', '%s', 1, 0, 0, 1, 0),<BR>";
        echo sprintf($data,
            $i+$id+1,
            PASSWORD,
            str_replace(['example.com', 'example.org', 'example.net'], 'plm.edu.ph', $faker->safeEmail()),
            $faker->firstName(),
            strtoupper($faker->randomLetter()),
            $faker->lastName(),
        );
    }
    echo "INSERT INTO crs_facultyinfo (facultyUser_id, facultyID, facultyWorkStatus, facultyGender, facultyCivilStatus, facultyCitizenship, facultyContact, facultyIn, facultyOut, collegeID_id, departmentID_id) VALUES <BR>";
    for ($i=0; $i < $number; $i++) {
        $data2 = "(%d, %d, '%s', '%s', '%s', 'Filipino', '09123456789', '7:00', '20:00', 1, %d ),<br>";
        echo sprintf($data2,
            $i+$id+1,
            $i+201900000,
            $faker->randomElement(['Part-Time', 'Full-Time']),
            $faker->randomElement(['Male', 'Female']),
            $faker->randomElement(['Single', 'Married', 'Divorced', 'Separated', 'Widow']),
            $faker->randomElement([1,2])
        );
        $_SESSION['last_user_id'] = $i+$id+1;
    }
};

$create_sections = function () {
    echo "INSERT INTO crs_section (blockYear, blockSection, blockCourse, curryear, college_id, adviser_id) VALUES (1, 1, 'BSIT', '2020', 1, (SELECT facultyUser_id from crs_facultyinfo ORDER BY RAND() LIMIT 1 ))<BR>";
    echo "INSERT INTO crs_section (blockYear, blockSection, blockCourse, curryear, college_id, adviser_id) VALUES (1, 1, 'BSEE', '2020', 1, (SELECT facultyUser_id from crs_facultyinfo ORDER BY RAND() LIMIT 1 ))<BR>";
};

$create_student = function (int $number) use ($faker) {
    echo "INSERT INTO crs_user (id, password, email, firstName, middleName, lastName, is_active, is_admin, is_chairperson, is_faculty, is_student) VALUES <br>";
    $id = $_SESSION['last_user_id'];
    for ($i=0; $i < $number; $i++) {
        $data = "( %d, '%s', '%s', '%s', '%s', '%s', 1, 0, 0, 0, 1),<BR>";
        echo sprintf($data,
            $i+$id+1,
            PASSWORD,
            str_replace(['example.com', 'example.org', 'example.net'], 'plm.edu.ph', $faker->safeEmail()),
            $faker->firstName(),
            strtoupper($faker->randomLetter()),
            $faker->lastName(),
        );
    }
    echo "INSERT INTO crs_studentinfo (
     studentUser_id, student_ID, studentGender,
     studentCitizenship, studentCivilStatus, studentContact,
     studentRegStatus, studentType, studentCourse, studentYearLevel,
     collegeID_id, departmentID_id, studentSection_id
 ) VALUES <br>";
    for ($i=0; $i < $number; $i++) {
        $data2 = "(%d, %d, '%s', 'Filipino', 'Single', '09123456789', '%s', '%s', '%s', '1', %d, %d, %d),<br>";
        $section = $faker->randomElement([1,2]);
        if($section === 1) {
            $course = 'BSIT';
        }
        if($section === 2) {
            $course = 'BSEE';
        }
        echo sprintf($data2,
            $i+$id+1,
            $i+202200000,
            $faker->randomElement(['Male', 'Female']),
            $faker->randomElement(['Regular', 'Irregular']),
            $faker->randomElement(['Old', 'New']),
            $course,
            1,
            $section,
            $section
        );
    };
};
//$create_faculty(50);
create_college();
create_chairperson();
create_department();
$create_faculty(3);
$create_sections();
$create_student(10);


