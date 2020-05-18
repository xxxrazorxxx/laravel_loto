<?php


namespace App\Core\TicketGenerator;


/**
 * Class TicketGenerator
 *
 * @package App\Core\TicketGenerator
 */
class TicketGenerator
{
    /** @var int */
    private $fields_num = 2;

    /** @var int  */
    private $rows_num = 3;

    /** @var int  */
    private $row_column_num = 9;

    /** @var int  */
    private $filled_columns_in_row_num = 5;

    /** @var array  */
    private $used_numbers = [];

    /**
     * Generates ticket
     *
     * @return array
     */
    public function generateTicket()
    {
        $data = [];
        $data['fields'] = $this->generateFields();

        return $data;
    }

    /**
     * Generates ticket fields
     *
     * @return array
     */
    private function generateFields()
    {
        $fields = [];

        while (count($fields) < $this->fields_num) {
            $fields[] = $this->generateRows();
        }

        return $fields;
    }

    /**
     * Generates field rows
     *
     * @return array
     */
    private function generateRows()
    {
        $rows = [];

        while (count($rows) < $this->rows_num) {
            $rows[] = $this->generateRow();
        }

        return $rows;
    }

    /**
     * Generate field row
     *
     * @return array
     */
    private function generateRow()
    {
        $filled_columns = $this->getRandomColumns();
        $row_data = [];

        foreach ($filled_columns as $column) {
            while(empty($row_data[$column])) {
                if ($column === 0) {
                    $rand_number = rand(1, 9);
                } elseif ($column === $this->row_column_num - 1) {
                    $rand_number = rand(0, 10);
                } else {
                    $rand_number = rand(0, 9);
                }

                $number = ($column * 10) + $rand_number;

                if (in_array($number, $this->used_numbers)) {
                    continue;
                }

                $this->used_numbers[] = $number;
                $row_data[$column] = $number;
            }
        }

        return $row_data;
    }

    /**
     * Generates random columns
     *
     * @return array
     */
    private function getRandomColumns()
    {
        $columns = [];

        while (count($columns) < $this->filled_columns_in_row_num) {
            $int = rand(0, $this->row_column_num - 1);
            if (in_array($int, $columns)) {
                continue;
            }
            $columns[] = $int;
        }

        return $columns;
    }
}
