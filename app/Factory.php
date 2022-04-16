<?php
declare(strict_types=1);
namespace App;

class Factory
{
    public function __construct(public \Faker\Generator $faker)
    {
    }

    /** FLOW
     * CREATE COLLEGE
     * CREATE CHAIRPERSON
     * CREATE DEPARTMENT
     * CREATE FACULTY
     * CREATE BLOCK_SECTION
     * CREATE STUDENTS
     * @return void
     */
    public function run()
    {
        //echo $this->college(Config::COLLEGE_SQL);
        //$this->userProvider(1, data: Config::CHAIRPERSON_SQL );
        $this->chairperson(Config::CHAIRPERSON_SQL);
    }

    public function college(array $sql)
    {
        [
            'table' => $table, 
            'values' => $values, 
            'data' => $data, 
            'config' => $config,
        ] = $sql;
        $modifiedValue = $this->concreteValueProvider($values);
        $newData = '';
        for ($i = 0; $i < count($data); $i++) {
           $newData .= sprintf("('%d', '%s', '%s'), ", $data[$i][$values['0']], $data[$i][$values['1']], $data[$i][$values['2']]);
        }
        $newData = rtrim($newData, ', ').';';
        return $this->sqlProvider($table, $modifiedValue, $newData);
    }

    public function chairperson(array $sql)
    {
        
    }

    private function userProvider(int $config, int $count = 1, array $data = []): string
    {
        [
            'table' => $table,
            'values' => $values
        ] = Config::USER_SQL;
        // if($config === 1) {
        //     $newData = '';
        //     for ($i=0; $i < count($data); $i++) { 
        //         $newData .= sprintf("('%d', '%s', '%s', '%s', '%s', '%s', %d, %d, %d, %d, %d)", $_SESSION['last_user_id'], );
        //     }
        // }
        
        if($config === 2) {

        }
    }

    public function sqlProvider(string $table, string $values, string $data): string
    {
        return "INSERT INTO $table $values VALUES $data;";
    }

    /**
     * Only for concrete configs
     *
     * @param array $values
     * @return string
     */
    private function concreteValueProvider(array $values): string
    {
        return '('.implode(', ', $values).')';
    }

    private function configProvider(string $config): int
    {
        if ($config === 'concrete') return 1;
        if ($config === 'faker') return 2;
        return 0;
    }
}