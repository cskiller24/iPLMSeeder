<?php

namespace App;

class Config
{
    public const DEPARTMENTS = [
        'BSIT' => 'Bachelor of Science in Information Technology',
        'BSEE' => 'Bachelor of Science in Electrical Engineering'
    ];
    public const EMAIL_DOMAIN = '@plm.edu.ph';
    public const PASSWORD = 'passwordInput';
    public const CHAIRPERSON = '1, 0, 1, 0, 0';
    public const ADMIN = '1, 1, 0, 0, 0';
    public const STUDENTS = '1, 0, 0, 0, 1';
    public const FACULTY = '1, 0, 0, 1, 0';
    public const NUMBER_OF_SECTIONS = 6;
    public const STUDENT_CODE = '202200000';
    public const SESSION_ID = 'last_user_id';

    public const COLLEGE_SQL = [
        'table' => 'crs_college',
        'using' => null,
        'values' => ['id', 'collegeName', 'collegeDesc'],
        'config' => 'concrete',
        'data' => [
            ['id' => '1', 'collegeName' => 'CET', 'collegeDesc' => 'College of Engineering and Technology'],
        ],
    ];

    public const USER_SQL = [
        'table' => 'crs_user',
        'values' => [
            'id', 
            'password', 
            'email', 
            'firstName', 
            'middleName', 
            'lastName', 
            'is_active', 
            'is_admin', 
            'is_chairperson', 
            'is_faculty', 
            'is_student'
        ],
    ];

    public const CHAIRPERSON_SQL = [
        'table' => 'crs_chairpersoninfo',
        'values' => 'cpersonUser_id',
        'config' => 'concrete',
        'using' => 'crs_user',
        'data' => [
            'crs_user' => [
                'id' => self::SESSION_ID,
                'password' => self::PASSWORD,
                'email' => 'cmmolina@plm.edu.ph',
                'firstName' => 'C', 
                'middleName' => 'M',
                'lastName' => 'Molina',
                'is_active' => 1,
                'is_admin' => 1,
                'is_chairperson' => 1,
                'is_faculty' => 1,
                'is_student' => 0
            ],
            '' => ''
        ]
    ];

    public const FACULTY_SQL = [
        'table' => 'crs_facultyinfo',
        'using' => 'crs_user',
        'values' => [
            'facultyUser_id', 
            'facultyID', 
            'facultyWorkStatus', 
            'facultyGender', 
            'facultyCivilStatus', 
            'facultyCitizenship',
            'facultyContact',
            'facultyIn',
            'facultyOut',
            'collegeID_id',
            'departmentID_id',
        ],
    ];

    public static function make(): Config
    {
        return new Config();
    }
}