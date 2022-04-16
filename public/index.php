<?php
declare(strict_types=1);
session_start();
$_SESSION['last_user_id'] = 1;
require "../vendor/autoload.php";
$faker = \Faker\Factory::create('en_PH');

const EMAIL_DOMAIN = '@plm.edu.ph';
const PASSWORD = 'passwordInput';
const CHAIRPERSON = '1, 0, 1, 0, 0';
const ADMIN = '1, 1, 0, 0, 0';
const STUDENTS = '1, 0, 0, 0, 1';
const FACULTY = '1, 0, 0, 1, 0';

// $fakerFactory = new App\Factory($faker);
//$fakerFactory->run();

function br() {
    echo "<br>";
}
function create_college() {
    echo "INSERT INTO crs_college (id, collegeName, collegeDesc) VALUES (1, 'CET', 'College of Engineering');";
}
function create_chairperson() {
    $id = $_SESSION['last_user_id'] + 1;
    echo "INSERT INTO crs_user (id, password, email, firstName, middleName, lastName, is_active, is_admin, is_chairperson, is_faculty, is_student)VALUES ($id, 'passwordInput', 'cmmolina@plm.edu.ph', 'C', 'M', 'Molina',".CHAIRPERSON.");";
    $_SESSION['last_user_id']++;
}

function create_department() {
    echo "INSERT INTO crs_department (courseName, collegeID_id, chairperson_id, courseDesc) VALUES ('BSIT', 1, (SELECT cpersonUser_id from crs_chairpersoninfo LIMIT 1), 'Bachelor of Science in Information Technology');";
    echo "INSERT INTO crs_department (courseName, collegeID_id, chairperson_id, courseDesc) VALUES ('BSEE', 1, (SELECT cpersonUser_id from crs_chairpersoninfo LIMIT 1), 'Bachelor of Science in Electrical Engineering');";
}

$create_faculty = function (int $number) use ($faker){
    $id = $_SESSION['last_user_id'];
    echo "INSERT INTO crs_facultyinfo (facultyUser_id, facultyID, facultyWorkStatus, facultyGender, facultyCivilStatus, facultyCitizenship, facultyContact, facultyIn, facultyOut, collegeID_id, departmentID_id) VALUES ($id, '201800000', 'Full-Time', 'Female', 'Single', 'Filipino', '09123456789', '7:00', '20:00', 1, 1);";
    echo "<br>";
    echo "<br>";
    echo "INSERT INTO crs_user (id, password, email, firstName, middleName, lastName, is_active, is_admin, is_chairperson, is_faculty, is_student) VALUES ";
    for ($i=0; $i < $number; $i++) {
        $data = "( %d, '%s', '%s', '%s', '%s', '%s', 1, 0, 0, 1, 0),";
        echo sprintf($data,
            $i+$id+1,
            PASSWORD,
            str_replace(['example.com', 'example.org', 'example.net'], 'plm.edu.ph', $faker->unique()->safeEmail()),
            str_replace("'", " ", $faker->firstName()),
            strtoupper($faker->randomLetter()),
            str_replace("'", " ", $faker->lastName()),
        );
    }
    echo "INSERT INTO crs_facultyinfo (facultyUser_id, facultyID, facultyWorkStatus, facultyGender, facultyCivilStatus, facultyCitizenship, facultyContact, facultyIn, facultyOut, collegeID_id, departmentID_id) VALUES ";
    for ($i=0; $i < $number; $i++) {
        $data2 = "(%d, %d, '%s', '%s', '%s', 'Filipino', '09123456789', '7:00', '20:00', 1, %d ),";
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
    /**
        *INSERT INTO crs_blocksection(blockYear, blockSection, blockCourse, curryear, college_id, adviser_id) VALUES 
        *(1,1,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(1,2,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(1,3,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(1,4,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(1,5,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(1,6,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(1,'Irregular','BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1));
        *
        *INSERT INTO crs_blocksection(blockYear, blockSection, blockCourse, curryear, college_id, adviser_id) VALUES 
        *(1,1,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(1,2,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(1,3,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(1,4,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(1,5,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(1,6,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(1,'Irregular','BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1));
        *
        *INSERT INTO crs_blocksection(blockYear, blockSection, blockCourse, curryear, college_id, adviser_id) VALUES 
        *(2,1,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(2,2,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(2,3,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(2,4,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(2,5,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(2,6,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(2,'Irregular','BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1));
        *
        *INSERT INTO crs_blocksection(blockYear, blockSection, blockCourse, curryear, college_id, adviser_id) VALUES 
        *(2,1,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(2,2,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(2,3,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(2,4,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(2,5,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(2,6,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(2,'Irregular','BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1));
        *
        *INSERT INTO crs_blocksection(blockYear, blockSection, blockCourse, curryear, college_id, adviser_id) VALUES 
        *(3,1,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(3,2,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(3,3,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(3,4,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(3,5,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(3,6,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(3,'Irregular','BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1));
        *
        *INSERT INTO crs_blocksection(blockYear, blockSection, blockCourse, curryear, college_id, adviser_id) VALUES 
        *(3,1,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(3,2,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(3,3,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(3,4,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(3,5,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(3,6,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(3,'Irregular','BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1));
        *
        *INSERT INTO crs_blocksection(blockYear, blockSection, blockCourse, curryear, college_id, adviser_id) VALUES 
        *(4,1,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(4,2,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(4,3,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(4,4,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(4,5,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(4,6,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(4,'Irregular','BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1));
        *
        *INSERT INTO crs_blocksection(blockYear, blockSection, blockCourse, curryear, college_id, adviser_id) VALUES 
        *(4,1,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(4,2,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(4,3,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(4,4,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(4,5,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(4,6,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(4,'Irregular','BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1));
        *
        *INSERT INTO crs_blocksection(blockYear, blockSection, blockCourse, curryear, college_id, adviser_id) VALUES 
        *(6,1,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(5,1,'BSIT',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(5,1,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1)),
        *(6,1,'BSEE',2022,1, (SELECT facultyUser_id FROM crs_facultyinfo ORDER BY RAND() LIMIT 1));
    */
};

$create_student = function () use ($faker) {
//     echo "INSERT INTO crs_user (id, password, email, firstName, middleName, lastName, is_active, is_admin, is_chairperson, is_faculty, is_student) VALUES ";
//     $id = $_SESSION['last_user_id'];
//     for ($i=0; $i < 20; $i++) {
//         $data = "( %d, '%s', '%s', '%s', '%s', '%s', 1, 0, 0, 0, 1),";
//         echo sprintf($data,
//             $i+$id+1,
//             PASSWORD,
//             str_replace(['example.com', 'example.org', 'example.net'], 'plm.edu.ph', $faker->safeEmail()),
//             str_replace("'", " ", $faker->firstName()),
//             strtoupper($faker->randomLetter()),
//             str_replace("'", " ", $faker->lastName()),
//         );
//     }
//     echo "INSERT INTO crs_studentinfo (
//     studentUser_id, studentID, studentGender,
//     studentCitizenship, studentCivilStatus, studentContact,
//     studentRegStatus, studentType, studentCourse, studentYearLevel,
//     collegeID_id, departmentID_id, studentSection_id
//  ) VALUES";
//     for ($i=0; $i < $number; $i++) {
//         $data2 = "(%d, %d, '%s', 'Filipino', 'Single', '09123456789', '%s', '%s', '%s', '1', %d, %d, %d),";
//         $section = $faker->randomElement([1,2]);
//         if($section === 1) {
//             $course = 'BSIT';
//         }
//         if($section === 2) {
//             $course = 'BSEE';
//         }
//         echo sprintf($data2,
//             $i+$id+1,
//             $i+202200000,
//             $faker->randomElement(['Male', 'Female']),
//             $faker->randomElement(['Regular', 'Irregular']),
//             $faker->randomElement(['Old', 'New']),
//             $course,
//             1,
//             $section,
//             $section
//         );
//     };
    echo "<BR>";
    echo "<BR>";
    echo "<BR>";
    echo "INSERT INTO crs_user (id, password, email, firstName, middleName, lastName, is_active, is_admin, is_chairperson, is_faculty, is_student) VALUES ";
    $id = $_SESSION['last_user_id'];
    for ($i=0; $i < 961; $i++) {
        $data = "( %d, '%s', '%s', '%s', '%s', '%s', 1, 0, 0, 0, 1),";
        echo sprintf($data,
            $i+$id+1,
            PASSWORD,
            str_replace(['example.com', 'example.org', 'example.net'], 'plm.edu.ph', $faker->unique()->safeEmail()),
            str_replace("'", " ", $faker->firstName()),
            strtoupper($faker->randomLetter()),
            str_replace("'", " ", $faker->lastName()),
        );
    }

    echo "INSERT INTO crs_studentinfo (
     studentUser_id, studentID, studentGender,
     studentCitizenship, studentCivilStatus, studentContact,
     studentRegStatus, studentType, studentCourse, studentYearLevel,
     collegeID_id, departmentID_id, studentSection_id
  ) VALUES ";
    $id = $_SESSION['last_user_id'];
    $student_code = 202200000;
    for($k = 1; $k < 3; $k++) {
        for($i = 1; $i < 5; $i++) {
            for($j = 1; $j < 7; $j++) {
                for($l = 1; $l < 21; $l++) {
                    $toSql = "(%d, %d, '%s', 'Filipino', 'Single', '09123456789', '%s', '%s', '%s', %d, 1, %d, %d),";
                    if($k === 1) {
                        $course = "BSIT";
                    } else if ($k === 2) {
                        $course = "BSEE";
                    }
                    echo sprintf(
                        $toSql, 
                        ++$id, 
                        ++$student_code,     
                        $faker->randomElement(['Male', 'Female']),
                        $faker->randomElement(['Regular', 'Irregular']),
                        $faker->randomElement(['Old', 'New']),
                        $course,
                        $i,
                        $k,
                        $j
                    );
                }
            }
        }
    }
};
create_college();
create_chairperson();
create_department();
$create_faculty(20);
// $create_sections();
$create_student();

// echo ";";

